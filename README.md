## 🚀 Überblick

Ein Web-Projekt zur Speicherung und Analyse von Items, inklusive Preisentwicklung, Suche, Benachrichtigungen und einer automatischen API-Synchronisation.

## 📝 To-Do-Liste  

### **🛠️ Authentifizierung & User-Sessions**  
- [ ] **Login- & Session-System einrichten**  
  - [ ] Nutzer können sich einloggen & bleiben eingeloggt  
  - [ ] Gespeicherte Daten (z. B. angeheftete Items) sind user-spezifisch  
- [ ] **Registrierung ermöglichen (falls notwendig)**  
  - [ ] Nutzer können sich neu registrieren  
  - [ ] Hashing der Passwörter (bcrypt o. Ä.)  
- [ ] **Session-Handling für eingeloggte User**  
  - [ ] Bei Logout werden Sessions gelöscht  
  - [ ] Sicherheitsmaßnahmen (Token, CSRF-Schutz, etc.)  

### **📂 Datenbank & API**  
- [ ] **CHECKEN OB MULTICURL ÜBERHAUPT NOTWENDIG IST WEIL [HIER](https://documenter.getpostman.com/view/4028519/TzK2bEVg#1c15b03d-a58b-4c0b-859c-5da9f74d6679) "If multiple ids are given..."**  
- [ ] **Items in Datenbank speichern** (alle Daten außer Preisangaben)  
- [ ] **Alle Items von der API abrufen und speichern**  
  - [ ] Vorher Datenbank leeren, um eine frische Datenbasis zu haben  
- [ ] **Preise pro Item anhand der ID abrufen und speichern**  
- [ ] **Höchsten Vorbestellpreis und niedrigsten Verkäuferpreis speichern**  
- [X] **Bilder speichern** (als Text in der DB oder als Datei im Cache-Verzeichnis zur Ladezeit-Optimierung)  
- [X] **ApiDataRepository überarbeiten**  
  - [X] Überarbeitung -> Verschiedene APIs in eigene Repositories  

### **📊 Preisberechnung & Anzeige**  
- [ ] Dropdown für Preisübersicht:  
  - [X] **Auf der Startseite**  
  - [ ] **Auf Detailseiten**  
- [ ] **Täglichen Item-Throughput ermitteln**  
  - [ ] Wie viele Items werden täglich eingestellt?  
  - [ ] Wie viele Items werden täglich verkauft?  
- [ ] **Preisprognosen basierend auf der bisherigen Entwicklung**  
  - [ ] **Schätzung für Preisveränderungen in den nächsten Tagen** (nur sinnvoll mit genügend Daten)  

### **🏠 Startseite & angeheftete Items**  
- [ ] **Startseite für eingeloggte User**  
  - [ ] Zeigt personalisierte Daten  
  - [X] Enthält eine Liste angehefteter Items  
- [ ] **Items anheften & wieder entfernen können**  
  - [ ] Nutzer können Items anpinnen  
  - [ ] Angepinnte Items bleiben in der Datenbank gespeichert  
  - [ ] Pro Nutzer individuelle angeheftete Items  

### **🔍 Suche & Navigation**  
- [ ] **Suchfunktion zum direkten Finden von Items**  
- [ ] **Hauptmenü mit Kategorien zur besseren Übersicht**  

### **🔔 Benachrichtigungen**  
- [X] **Benachrichtigungssystem einrichten**  
- [ ] **Einstellbare Benachrichtigungen für jedes Item**  
  - [ ] **Glocken-Symbol auf Item-Seite**  
  - [ ] **Popup/Banner zur Auswahl der Kriterien für Benachrichtigungen (Preis, Verfügbarkeit, etc.)**  

### **📈 Detailseite mit Graphen**  
- [ ] **Item-Detailseite erstellen**  
  - [ ] Preisentwicklung grafisch darstellen  

### **🔄 Automatische Updates & AJAX**  
- [X] **API alle paar Sekunden abrufen**  
- [X] **Daten automatisch aktualisieren**  

### **🔧 Architektur & Struktur**  
- [X] **Refactoring der einzelnen Klassen und Dateien**  
