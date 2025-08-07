-- Add header announcement fields to site_settings table
ALTER TABLE site_settings
ADD COLUMN header_announcement_enabled BOOLEAN DEFAULT FALSE AFTER meta_description,
ADD COLUMN header_announcement_text TEXT NULL AFTER header_announcement_enabled,
ADD COLUMN header_announcement_bg_color VARCHAR(7) DEFAULT '#667eea' AFTER header_announcement_text,
ADD COLUMN header_announcement_text_color VARCHAR(7) DEFAULT '#ffffff' AFTER header_announcement_bg_color;
