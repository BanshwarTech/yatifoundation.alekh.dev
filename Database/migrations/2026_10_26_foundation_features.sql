-- Foundation programs, verified impact metrics, public reports, and inbox status fields.
-- Apply once to the yatifoundation database. Existing submissions default to Pending/New.

CREATE TABLE IF NOT EXISTS programs (
    programId INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    summary VARCHAR(500) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(80) NOT NULL DEFAULT 'fa-heart',
    sortOrder INT NOT NULL DEFAULT 0,
    isPublished TINYINT(1) NOT NULL DEFAULT 1,
    isDel TINYINT(1) NOT NULL DEFAULT 1,
    addedOn DATE NOT NULL,
    PRIMARY KEY (programId),
    UNIQUE KEY uq_programs_slug (slug),
    KEY idx_programs_published (isPublished, isDel, sortOrder)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO programs (title, slug, summary, description, icon, sortOrder, isPublished, isDel, addedOn) VALUES
('Education and Learning', 'education-learning', 'Learning support, mentoring and school resources for children and young people.', 'This area focuses on learning support, mentoring and access to school resources for children and young people. Contact the foundation to ask which activities are currently available in your community.', 'fa-graduation-cap', 1, 1, 1, CURRENT_DATE),
('Community Health', 'community-health', 'Community health awareness and wellbeing support for families.', 'This area focuses on community health awareness and family wellbeing. Contact the foundation to confirm current activities, timings and locations.', 'fa-heart-pulse', 2, 1, 1, CURRENT_DATE),
('Skills and Livelihoods', 'skills-livelihoods', 'Skills development and livelihood support to help people build opportunities.', 'This area focuses on practical skills development and livelihood opportunities. Contact the foundation for information about current activities and participation.', 'fa-seedling', 3, 1, 1, CURRENT_DATE);

CREATE TABLE IF NOT EXISTS impact_metrics (
    metricId INT NOT NULL AUTO_INCREMENT,
    label VARCHAR(120) NOT NULL,
    metricValue INT UNSIGNED NOT NULL DEFAULT 0,
    suffix VARCHAR(12) NOT NULL DEFAULT '',
    icon VARCHAR(80) NOT NULL DEFAULT 'fa-chart-line',
    sortOrder INT NOT NULL DEFAULT 0,
    isPublished TINYINT(1) NOT NULL DEFAULT 0,
    isDel TINYINT(1) NOT NULL DEFAULT 1,
    updatedOn DATE NOT NULL,
    PRIMARY KEY (metricId),
    KEY idx_metrics_published (isPublished, isDel, sortOrder)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reports (
    reportId INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(80) NOT NULL DEFAULT 'Annual report',
    reportYear SMALLINT UNSIGNED NOT NULL,
    fileName VARCHAR(250) NOT NULL,
    isPublished TINYINT(1) NOT NULL DEFAULT 1,
    isDel TINYINT(1) NOT NULL DEFAULT 1,
    addedOn DATE NOT NULL,
    PRIMARY KEY (reportId),
    KEY idx_reports_published (isPublished, isDel, reportYear)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE donate ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Pending';
ALTER TABLE vounteer ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Pending';
ALTER TABLE contact ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'New';
