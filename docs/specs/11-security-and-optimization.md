# Security and Optimization

## Description
The Origamiez theme includes a dedicated layer for security and performance optimization. This component is responsible for protecting the theme from common web vulnerabilities (XSS, Clickjacking, Login Brute-forcing) and ensuring that user inputs are properly sanitized before processing.

## Core Architecture
- **Main Class/File**: `Origamiez\Hooks\Hooks\SecurityHooks` (`origamiez/app/Hooks/Hooks/SecurityHooks.php`)
- **Dependencies**: 
    - `Origamiez\Hooks\HookRegistry`: Used to register security-related hooks.
    - WordPress Core functions: `sanitize_text_field`, `set_transient`, `get_transient`, etc.
- **Patterns Used**: 
    - **Observer (Hooks)**: Hooks into core WordPress events to inject security logic.
    - **Middleware-like Logic**: Acts as a filter for headers and search queries.

## Implementation Details
- **How it works**: 
    1.  **Search Protection**: The `sanitize_search_query` method hooks into `pre_get_posts` to sanitize search terms by stripping HTML (`sanitize_text_field`) and limiting length to 100 characters for non-admin main queries. (Note: Search nonces have been removed to improve compatibility and simplify the user experience).
    2.  **Security Headers**: Injects essential HTTP security headers (`X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`) and a strict `Content-Security-Policy` (CSP) during the `send_headers` action.
    3.  **Brute-force Mitigation**: Tracks failed login attempts using WordPress transients (`origamiez_login_attempts_`). It increments a counter for each failed attempt per username, providing a foundation for blocking repeat offenders.
- **Key Functions/Methods**:
    - `sanitize_search_query(query)`: Validates and cleans search terms in the `WP_Query` object.
    - `add_security_headers()`: Sets HTTP headers to prevent common browser-based attacks.
    - `track_failed_login(username)`: Increments the login failure counter in a transient.
    - `clear_login_attempts(user_login)`: Resets the failure counter upon successful login.

## Maintenance & Development
- **Updating CSP**: The Content Security Policy is defined in `add_security_headers()`. If new external scripts or styles are added (e.g., a new font provider), they must be added to the `$csp` string.
- **Adjusting Login Limits**: The expiration time for login attempt tracking is currently set to 15 minutes in `track_failed_login()`.
- **Common Issues**: 
    - **CSP Blocking Assets**: If a legitimate external resource is blocked by the browser, check the `Content-Security-Policy` header in `SecurityHooks.php`.

## Related Files
- `origamiez/app/Hooks/Hooks/SecurityHooks.php`
- `origamiez/searchform.php`
