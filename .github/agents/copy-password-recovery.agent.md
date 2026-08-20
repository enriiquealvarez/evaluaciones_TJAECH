---
name: "Copy Password Recovery"
description: "Use when: you need to copy the complete password recovery functionality (controller, model, views, and routes) from this system to another project. Analyzes AdminPasswordReset module and adapts it to the target system structure."
mode: "multi-step"
outputFormat: "markdown"
---

# Password Recovery Module Copy Agent

## Purpose
Automatically copy and adapt the complete password recovery functionality from this system to another development project.

## What This Agent Does

### Step 1: Analyze Source System
- Reads `AdminPasswordReset` controller and model from current project
- Analyzes views: `forgot.php`, `reset.php`
- Checks database schema and validation rules
- Reviews email configuration in `config/mail.php`

### Step 2: Analyze Target System
- Explores the target project structure at: `laragon\www\tjaech_transparencia_combinado`
- Identifies controller/model/view conventions
- Checks existing authentication implementation
- Determines routing pattern

### Step 3: Adapt and Generate
- Generates adapted versions of all components
- Updates namespace, class names, and paths
- Maintains functionality but follows target project conventions
- Includes any required database migrations

### Step 4: Implement
- Creates/updates files in target project:
  - `app/Controllers/AdminPasswordResetController.php`
  - `app/Models/AdminPasswordReset.php`
  - `app/Views/admin/forgot.php`
  - `app/Views/admin/reset.php`
- Adds routes to target project's router
- Updates database schema if needed

## How to Use

In VS Code Copilot Chat, simply ask:

```
Copy the password recovery functionality to the other project
```

Or be more specific:

```
I need to copy the AdminPasswordReset module (forgot.php, reset.php, model, controller) 
to the tjaech_transparencia_combinado project. Make it compatible with their structure.
```

## Components Copied

| Component | Source | Target |
|-----------|--------|--------|
| Controller | `app/Controllers/AdminAuthController.php` (method) | `app/Controllers/AdminAuthController.php` |
| Model | `app/Models/AdminPasswordReset.php` | `app/Models/AdminPasswordReset.php` |
| Views | `app/Views/admin/{forgot.php, reset.php}` | `app/Views/admin/{forgot.php, reset.php}` |
| Database | Tables and fields required | Migration file |
| Routes | Current router config | Target router config |

## Prerequisites

- Both projects must have proper authentication setup
- Target project must have Mailer configured
- Database access and migration capability in target

## Output

After execution, the agent will:
✅ Confirm all files copied successfully  
✅ Show any required configuration changes  
✅ List database changes needed  
✅ Provide testing instructions  
