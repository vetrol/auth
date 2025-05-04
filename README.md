# Vetrol Auth

**Vetrol Auth** is a modular, secure, and extensible Laravel package that fills in the missing pieces of Laravel’s authentication system — built for modern web applications by [Vetrol](https://vetrol.io).

---

## 🔐 Features

- ✅ Multiple Email Addresses per User
- 🔐 2FA / MFA (Email, SMS, Authenticator, Push)
- ✉️ Magic Links Login
- 🔑 Passkeys (WebAuthn) – biometric login
- 📍 OTP on Login / New Location
- 📅 Password Expiry Enforcement
- ⚙️ Fully Configurable via `config/vetrol-auth.php`
- 🧬 Supports Polymorphic User Models
- 🛡️ Secure by Design (signed URLs, rate-limiting, token hashing)

---

## 📦 Installation

```bash
composer require vetrol/auth
```

Then publish the config and run migrations:
```
php artisan vendor:publish --tag=vetrol-auth-config
php artisan migrate
```

## 🤝 Contributing
Pull requests and issue reports are welcome! Please submit issues or ideas to improve this package.

## 📄 License
Vetrol Auth is an open-sourced software licensed under the MIT license.
