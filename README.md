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
- [ ] **Items in Datenbank speichern** (alle Daten außer Preisangaben)  
- [ ] **Alle Items von der API abrufen und speichern**  
  - [ ] Vorher Datenbank leeren, um eine frische Datenbasis zu haben  
- [ ] **Preise pro Item anhand der ID abrufen und speichern**  
- [ ] **Höchsten Vorbestellpreis und niedrigsten Verkäuferpreis speichern**  
- [X] **Bilder speichern** (als Text in der DB oder als Datei im Cache-Verzeichnis zur Ladezeit-Optimierung)  
- [ ] **ApiDataRepository überarbeiten**  
  - [ ] Verschiedene APIs benötigen eigene Repositories  
  - [ ] Prüfen, ob ein `ApiController` sinnvoll ist oder nicht  

### **📊 Preisberechnung & Anzeige**  
- [ ] Dropdown für Preisübersicht mit folgenden Werten:  
  - [ ] **Durchschnitt der letzten 7 Tage**  
  - [ ] **Durchschnitt der letzten 14 Tage**  
  - [ ] **Durchschnitt der letzten 31 Tage**  
- [ ] **Täglichen Item-Throughput ermitteln**  
  - [ ] Wie viele Items werden täglich eingestellt?  
  - [ ] Wie viele Items werden täglich verkauft?  
- [ ] **Preisprognosen basierend auf der bisherigen Entwicklung**  
  - [ ] **Schätzung für Preisveränderungen in den nächsten Tagen** (nur sinnvoll mit genügend Daten)  

### **🏠 Startseite & angeheftete Items**  
- [ ] **Startseite für eingeloggte User**  
  - [ ] Zeigt personalisierte Daten  
  - [ ] Enthält eine Liste angehefteter Items  
- [ ] **Items anheften & wieder entfernen können**  
  - [ ] Nutzer können Items anpinnen  
  - [ ] Angepinnte Items bleiben in der Datenbank gespeichert  
  - [ ] Pro Nutzer individuelle angeheftete Items  

### **🔍 Suche & Navigation**  
- [ ] **Suchfunktion zum direkten Finden von Items**  
- [ ] **Hauptmenü mit Kategorien zur besseren Übersicht**  

### **🔔 Benachrichtigungen**  
- [ ] **Benachrichtigungssystem einrichten**  
- [ ] **Einstellbare Benachrichtigungen für jedes Item**  
  - [ ] **Glocken-Symbol auf Item-Seite**  
  - [ ] **Popup/Banner zur Auswahl der Kriterien für Benachrichtigungen (Preis, Verfügbarkeit, etc.)**  

### **📈 Detailseite mit Graphen**  
- [ ] **Item-Detailseite erstellen**  
  - [ ] Preisentwicklung grafisch darstellen  

### **🔄 Automatische Updates & AJAX**  
- [ ] **API jede Minute abrufen**  
- [ ] **Daten automatisch aktualisieren (AJAX, kein Reload nötig)**  

---

## **🔧 Architektur & Struktur**  

### **📂 Repository-Struktur (Trennung API & Datenbank)**  
Um die Code-Struktur **übersichtlich & wartbar** zu halten, werden **API-Daten und die lokale Datenbank getrennt behandelt**.  
**Die Repositories sind nur für das Abrufen von Daten verantwortlich**, die eigentliche Logik kommt in die Services.  

```txt
/src
 ├── /Repository
 │   ├── MarketItemRepository.php       <-- Holt Item-Daten aus der API
 │   ├── MarketPriceRepository.php      <-- Holt Preis-Daten aus der API
 │   ├── MarketTrendingRepository.php   <-- Holt Trends aus der API
 │   ├── LocalDatabaseRepository.php    <-- Verwaltet die lokale DB (Item-Speicherung)
 │   ├── AbstractApiRepository.php      <-- Basis für API-Repositories
 │   ├── AbstractDatabaseRepository.php <-- Basis für DB-Repositories
 │
 ├── /Service
 │   ├── ApiService.php                 <-- Vermittelt zwischen API & lokaler DB
 │   ├── ItemService.php                <-- Verarbeitet Daten für UI
 │   ├── UserService.php                <-- Logik für Logins, Registrierungen, Sessions
 │
 ├── /Controller
 │   ├── AuthController.php             <-- Login, Logout, Registrierung
