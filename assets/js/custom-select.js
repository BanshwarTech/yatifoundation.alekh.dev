(() => {
    const iconFor = (label) => {
        const value = label.toLowerCase();
        if (value.includes('razorpay') || value.includes('payment')) return 'fa-credit-card';
        if (value.includes('cashfree')) return 'fa-building';
        if (value.includes('sandbox') || value.includes('test')) return 'fa-flask';
        if (value.includes('production') || value.includes('live')) return 'fa-rocket';
        if (value.includes('female') || value.includes('woman')) return 'fa-female';
        if (value.includes('male') || value.includes('man')) return 'fa-male';
        if (value.includes('other')) return 'fa-ellipsis-h';
        if (value.includes('paid') || value.includes('received') || value.includes('complete') || value.includes('approved')) return 'fa-check-circle';
        if (value.includes('fail') || value.includes('reject') || value.includes('cancel')) return 'fa-times-circle';
        if (value.includes('pending') || value.includes('review')) return 'fa-clock-o';
        return 'fa-circle';
    };

    const close = (wrapper, restoreFocus = false) => {
        const trigger = wrapper.querySelector('.custom-select-trigger');
        const menu = wrapper.querySelector('.custom-select-menu');
        wrapper.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
        menu.hidden = true;
        if (restoreFocus) trigger.focus();
    };

    const closeOthers = (except) => {
        document.querySelectorAll('.custom-select.is-open').forEach((wrapper) => {
            if (wrapper !== except) close(wrapper);
        });
    };

    const enhance = (select) => {
        if (select.multiple || select.dataset.customSelectReady === 'true') return;
        select.dataset.customSelectReady = 'true';
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');

        const wrapper = document.createElement('div');
        wrapper.className = `custom-select${select.classList.contains('datatable-selector') ? ' custom-select-compact' : ''}`;
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);
        select.classList.add('custom-select-native');

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'custom-select-trigger';
        trigger.setAttribute('role', 'combobox');
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('aria-controls', `${select.id || 'select'}-options`);
        trigger.setAttribute('aria-required', select.required ? 'true' : 'false');
        trigger.disabled = select.disabled;
        if (select.id) trigger.id = `${select.id}-trigger`;

        const label = select.id ? document.querySelector(`label[for="${CSS.escape(select.id)}"]`) : null;
        const fieldsetLabel = select.closest('fieldset')?.querySelector('label');
        if (label || fieldsetLabel) {
            const labelNode = label || fieldsetLabel;
            if (!labelNode.id) labelNode.id = `${select.id || 'select'}-label`;
            trigger.setAttribute('aria-labelledby', labelNode.id);
            if (labelNode.htmlFor === select.id) labelNode.htmlFor = trigger.id;
        } else if (select.getAttribute('aria-label')) {
            trigger.setAttribute('aria-label', select.getAttribute('aria-label'));
        }

        const value = document.createElement('span');
        value.className = 'custom-select-value';
        const chevron = document.createElement('i');
        chevron.className = 'fa fa-chevron-down custom-select-chevron';
        chevron.setAttribute('aria-hidden', 'true');
        trigger.append(value, chevron);

        const menu = document.createElement('div');
        menu.className = 'custom-select-menu';
        menu.id = trigger.getAttribute('aria-controls');
        menu.setAttribute('role', 'listbox');
        menu.hidden = true;

        const options = Array.from(select.options).map((option, index) => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'custom-select-option';
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', option.selected ? 'true' : 'false');
            item.disabled = option.disabled;
            item.dataset.value = option.value;
            item.dataset.index = String(index);

            const icon = document.createElement('i');
            icon.className = `fa ${iconFor(option.textContent.trim())}`;
            icon.setAttribute('aria-hidden', 'true');
            const text = document.createElement('span');
            text.textContent = option.textContent.trim();
            item.append(icon, text);

            item.addEventListener('click', () => {
                select.selectedIndex = index;
                select.dispatchEvent(new Event('input', { bubbles: true }));
                select.dispatchEvent(new Event('change', { bubbles: true }));
                sync();
                close(wrapper, true);
            });

            item.addEventListener('keydown', (event) => {
                const enabled = options.filter((entry) => !entry.disabled);
                const current = enabled.indexOf(item);
                if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                    event.preventDefault();
                    enabled[(current + (event.key === 'ArrowDown' ? 1 : enabled.length - 1)) % enabled.length].focus();
                } else if (event.key === 'Home' || event.key === 'End') {
                    event.preventDefault();
                    enabled[event.key === 'Home' ? 0 : enabled.length - 1].focus();
                } else if (event.key === 'Escape') {
                    event.preventDefault();
                    close(wrapper, true);
                }
            });
            menu.appendChild(item);
            return item;
        });

        const sync = () => {
            const selected = select.options[select.selectedIndex];
            value.textContent = selected ? selected.textContent.trim() : '';
            value.classList.toggle('custom-select-placeholder', Boolean(selected && selected.value === ''));
            options.forEach((item, index) => {
                const isSelected = index === select.selectedIndex;
                item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
                item.classList.toggle('is-selected', isSelected);
            });
            wrapper.classList.toggle('has-value', Boolean(selected && selected.value));
            if (select.validity.valid) {
                wrapper.classList.remove('is-invalid');
                trigger.removeAttribute('aria-invalid');
            }
        };

        const open = () => {
            if (trigger.disabled) return;
            closeOthers(wrapper);
            wrapper.classList.add('is-open');
            menu.hidden = false;
            trigger.setAttribute('aria-expanded', 'true');
            const selected = options[select.selectedIndex];
            (selected && !selected.disabled ? selected : options.find((item) => !item.disabled))?.focus();
        };

        trigger.addEventListener('click', () => {
            if (wrapper.classList.contains('is-open')) close(wrapper);
            else open();
        });
        trigger.addEventListener('keydown', (event) => {
            if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                open();
            } else if (event.key === 'Escape') {
                close(wrapper);
            }
        });
        wrapper.addEventListener('focusout', () => window.setTimeout(() => {
            if (!wrapper.contains(document.activeElement)) close(wrapper);
        }, 0));
        select.addEventListener('change', sync);
        select.addEventListener('invalid', () => {
            wrapper.classList.add('is-invalid');
            trigger.setAttribute('aria-invalid', 'true');
            trigger.focus();
        });
        select.form?.addEventListener('reset', () => window.setTimeout(sync, 0));

        wrapper.append(trigger, menu);
        sync();
    };

    const initialize = () => {
        document.querySelectorAll('select').forEach(enhance);
        const observer = new MutationObserver((records) => {
            records.forEach((record) => record.addedNodes.forEach((node) => {
                if (!(node instanceof Element)) return;
                if (node.matches('select')) enhance(node);
                node.querySelectorAll('select').forEach(enhance);
            }));
        });
        observer.observe(document.body, { childList: true, subtree: true });
    };
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize, { once: true });
    else initialize();

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.custom-select')) closeOthers(null);
    });
})();
