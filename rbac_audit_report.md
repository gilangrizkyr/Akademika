# RBAC Audit Report - Akademika Portal

This report summarizes the findings of a comprehensive security audit focused on Role-Based Access Control (RBAC) and authorization logic.

## 1. Access Matrix (Final Validated State)

| Feature / Action | Superadmin | Admin | Researcher (User) | Public |
| :--- | :---: | :---: | :---: | :---: |
| **Dashboard Access** | ALLOWED | ALLOWED | ALLOWED | DENIED |
| **User Management** | ALLOWED | DENIED | DENIED | DENIED |
| **Website Settings** | ALLOWED | DENIED | DENIED | DENIED |
| **Database Backup** | ALLOWED | DENIED | DENIED | DENIED |
| **Category Mgmt** | ALLOWED | ALLOWED | DENIED | DENIED |
| **Tag Mgmt** | ALLOWED | ALLOWED | DENIED | DENIED |
| **Moderate Research** | ALLOWED | ALLOWED | DENIED | DENIED |
| **Edit/Delete (Own)** | ALLOWED | ALLOWED | ALLOWED | DENIED |
| **Edit/Delete (Others)** | ALLOWED | DENIED | DENIED | DENIED |
| **Live Search API** | ALLOWED | ALLOWED | ALLOWED | ALLOWED |
| **View Counter API** | ALLOWED | ALLOWED | ALLOWED | ALLOWED |

## 2. Audit Findings & Resolution

### [MEDIUM] Inconsistency in Category Management
- **Issue**: `CategoryController::index` restricted access only to `superadmin`, while the Route Filter allowed `admin`. This caused a 403/Redirect for Admins trying to manage categories.
- **Resolution**: Updated controller to allow both roles, aligning with the `TagsController` and business requirements.

### [LOW] Redundant but Inconsistent Route Filters
- **Issue**: `SettingsController` routes were defined outside the main dashboard group, leading to slightly different filter application patterns.
- **Resolution**: Unified all dashboard-related routes under the `dashboard` group for centralized security policy enforcement.

### [SECURE] Ownership Verification
- **Verified**: `ResearchController` and `SectionController` correctly verify `user_id` ownership before allowing `edit`, `update`, or `delete` actions. Superadmins are correctly exempted from this check for administrative purposes.

### [SECURE] API Protection
- **Verified**: Sensitive API endpoints (Bookmark toggle) require an active session and valid CSRF token. The `incrementView` endpoint is restricted to AJAX requests only.

## 3. Hardening Implementation

The following files were hardened with "Defense in Depth" (redundant server-side checks):
1. `app/Config/Routes.php`: Centralized filter application.
2. `app/Controllers/CategoryController.php`: Fixed role consistency.
3. `app/Controllers/ResearchController.php`: Added explicit role checks in moderation logic.
4. `app/Controllers/UserManagementController.php`: Verified superadmin exclusivity.

## 4. Edge Case Validation
- **ID Manipulation**: Attempting to edit a research by manually changing the ID in the URL is blocked by the ownership check in the `edit()` and `update()` methods.
- **CSRF Bypass**: All POST/PUT/DELETE requests are strictly validated against CSRF tokens via the global filter.
- **Privilege Escalation**: Attempting to set `role` to `superadmin` in the `update` user form is allowed only by existing Superadmins.
