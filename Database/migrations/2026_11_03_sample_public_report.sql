-- Add one clearly labelled preview report so the public reports page has an
-- example card. The document contains no real financial or impact figures.
INSERT INTO reports (
    title,
    description,
    category,
    reportYear,
    fileName,
    isPublished,
    isDel,
    addedOn
)
SELECT
    'Sample Community Update',
    'A preview of how a published report appears on the website. This sample contains illustrative content only.',
    'Sample report',
    2026,
    'sample-community-update-2026.pdf',
    1,
    1,
    '2026-11-03'
WHERE NOT EXISTS (
    SELECT 1
    FROM reports
    WHERE fileName = 'sample-community-update-2026.pdf'
);
