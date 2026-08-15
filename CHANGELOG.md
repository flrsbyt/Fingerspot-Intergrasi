# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2024-08-10

### Added
- Device control panel moved from settings to userinfos page
- Get Userinfo function with detailed logging and error handling
- Register Online function with enhanced error messages
- Webhook support for `get_userid_list` event type
- PIN data extraction from `data.pin_arr` webhook format
- Add device form directly on PIN page (replaced filter box)
- Consistent modern styling across all admin pages
- Modern styling for login and register pages

### Changed
- Updated Data PIN page UI - removed offline status badge and separate "Add" button
- Replaced filter box with inline add device form on PIN page
- Removed auto-reload after delete user action
- Removed reset filter button from userinfos page
- Updated styling for settings, pins, and userinfos pages to match dashboard/attlog/landing
- Updated guest layout with modern design and consistent styling
- Updated login and register pages with Bootstrap and modern styling

### Fixed
- Enhanced error handling for Get Userinfo and Register Online to display detailed API error messages
- Fixed webhook processing to correctly handle `get_userid_list` format with `data.pin_arr` structure
- Improved logging for debugging Fingerspot API requests and responses

### Technical
- Added detailed logging in FingerspotService for getUserinfo and registerOnline methods
- Enhanced CommandPanelController error responses with API data and raw response snippets
- Updated WebhookController to recognize and process `get_userid_list` event type
- Standardized color scheme (#0B0F19, #6366F1, #E6E8EC, #F3F4FF) across all pages
- Standardized fonts (Plus Jakarta Sans, Inter, JetBrains Mono) across all pages
