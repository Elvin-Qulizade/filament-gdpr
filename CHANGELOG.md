# Changelog

All notable changes to `filament-gdpr` will be documented in this file.

## 1.0.1 - 2026-09-29

- fix: `ModelDiscovery` failed to find models under the default `app/Models/` directory, leaving the retention policy "Target model" selector empty
- fix: `PersonalDataExporter` only searched `config('filament-gdpr.models')` (empty by default), so data-subject exports could silently complete with no data; it now also searches auto-discovered models

## 1.0.0 - 202X-XX-XX

- initial release
