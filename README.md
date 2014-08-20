Blog
====

*Work in Progress

## Inhalt

1. [Grunt Tasks](#grunttasks)
    1. [Task Übersicht](#grunttaskoverview)


## [Grunt Tasks](id:grunttasks)

### [Task Übersicht](id:grunttaskoverview)

| Parameter      | Task(s)               |
|----------------|-----------------------|
| `default`      | -> `build`
| `build`        | vollständiger Build-Job (`json_update`, `copy-deps`, `copy-css`, `copy-js`, `clean-temp`)
| `copy-deps`    | löscht existierende Abhängigkeiten, kopiert Abhängigkeiten neu aus *bower_components*
| `build-css`    | kompiliert SASS, fügt Vendor-Präfixe hinzu, kombiniert Media-Queries und konkateniert/minimiert CSS
| `build-js`     | konkateniert, linted und minimiert Javascripts
| `sync`         | startet BrowserSync und Watch
| `watch`        | startet Watch
| `update_json`  | aktualisiert Version und Name in _bower.json_ mit Daten aus _package.json_
| `clean-temp`   | löscht *assets-temp*

