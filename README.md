# 📸 PostVue

**PostVue** è un clone di Instagram che permette agli utenti di:
- Pubblicare foto
- Mettere "Mi piace"
- Commentare i post
- Seguire e smettere di seguire altri utenti

Il progetto è costruito con una solida architettura full-stack:  
🔧 Backend in **Laravel** · 🎨 Frontend SPA in **Vue.js** · ☁️ Archiviazione immagini con **AWS S3**

---

## ⚠️ Disclaimer

Questo è un progetto creato a scopo **didattico** e di **esercitazione personale**.  
PostVue **non è pensato per l’uso in produzione reale**.  
Nonostante segua buone pratiche, alcune funzionalità di sicurezza, performance e scalabilità potrebbero non essere completamente implementate.

Usalo liberamente per imparare, sperimentare o contribuire! 🚀

---

## 🚀 Funzionalità principali

- ✅ Autenticazione e registrazione utenti
- 📷 Upload e visualizzazione delle immagini
- ❤️ Like ai post
- 💬 Commenti in tempo reale
- ➕ Segui/Smetti di seguire utenti
- 🔄 Routing gestito lato client tramite Vue Router
- 📱 Responsive design ottimizzato per dispositivi mobili e desktop grazie a Tailwind CSS
- ☁️ Salvataggio immagini su AWS S3

---

## 🛠️ Tech stack

| Layer       | Tecnologia                  |
|-------------|-----------------------------|
| Backend     | Laravel                     |
| Frontend    | Vue.js + TailwindCSS        |
| Database    | PostgreSQL                  |
| Storage     | Amazon S3                   |
| Auth        | Laravel Sanctum / Jetstream |

---

## ⚙️ Setup del progetto

### Prerequisiti

- PHP >= 8.1
- Composer
- Node.js & npm
- PostgreSQL
- Accesso a un bucket S3 (con chiavi AWS configurate)

### Installazione

```bash
# Clona il repository
git clone https://github.com/pizziGa/postvue.git
cd postvue

# Installa le dipendenze PHP
composer install

# Installa le dipendenze JS
npm install

# Crea il file .env
cp .env.example .env

# Configura le variabili ambiente nel file .env
# (DB, AWS, ecc.)

# Genera la chiave dell'app
php artisan key:generate

# Esegui le migrazioni
php artisan migrate

# Avvia il server di sviluppo
php artisan serve

# In un secondo terminale, avvia il server Vite per hot reloading
npm run dev

```
---
## 📄 Licenza

Questo progetto è distribuito sotto la licenza [MIT](LICENSE).  
Puoi usarlo, modificarlo e distribuirlo liberamente, ma senza garanzie.  
Consulta il file `LICENSE` per i dettagli.
