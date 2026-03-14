# Security and Optimization

## Description
The Origamiez theme includes a dedicated layer for security and performance optimization. This component is responsible for protecting the theme from common web vulnerabilities (XSS, Clickjacking, Login Brute-forcing) and ensuring that user inputs are properly sanitized before processing.

## Core Architecture
- **Main Class/File**: `Origamiez\Engine\Hooks\Hooks\SecurityHooks` (`origamiez/engine/Hooks/Hooks/SecurityHooks.php`)
- **Dependencies**: 
    - `Origamiez\Engine\Hooks\HookRegistry`: Used to register security-related hooks.
    - WordPress Core functions: `wp_verify_nonce`, `sanitize_text_field`, `set_transient`, etc.
- **Patterns Used**: 
    - **Observer (Hooks)**: Hooks into core WordPress events to inject security logic.
    - **Middleware-like Logic**: Acts as a filter for headers and search queries.

## Implementation Details
- **How it works**: 
    1.  **Search Protection**: Verifies nonces for search requests and sanitizes search queries by stripping HTML and limiting length to 100 characters.
    2.  **Security Headers**: Injects essential HTTP security headers (`X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`) and a strict `Content-Security-Policy` (CSP) during the `send_headers` action.
    3.  **Brute-force Mitigation**: Tracks failed login attempts using WordPress transients. It increments a counter for each failed attempt per username, providing a foundation for blocking repeat offenders.
- **Key Functions/Methods**:
    - `verify_search_nonce()`: Validates the `search_nonce` field in search queries.
    - `add_security_headers()`: Sets HTTP headers to prevent common browser-based attacks.
    - `track_failed_login(username)`: Increments the login failure counter in a transient.
    - `clear_login_attempts(user_login)`: Resets the failure counter upon successful login.

## Maintenance & Development
- **Updating CSP**: The Content Security Policy is defined in `add_security_headers()`. If new external scripts or styles are added (e.g., a new font provider), they must be added to the `$csp` string.
- **Adjusting Login Limits**: The expiration time for login attempt tracking is currently set to 15 minutes in `track_failed_login()`.
- **Common Issues**: 
    - **CSP Blocking Assets**: If a legitimate external resource is blocked by the browser, check the `Content-Security-Policy` header in `SecurityHooks.php`.
- **Future Improvements**:
    - Implement a permanent block (IP-based) for repeated failed login attempts.
    - Add object caching support for security transients.

## Related Files
- `origamiez/engine/Hooks/Hooks/SecurityHooks.php`
- `origamiez/searchform.php` (Where nonces are generated)
