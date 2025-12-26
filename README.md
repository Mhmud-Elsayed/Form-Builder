🧩 Form Builder – Multi-Tenant SaaS (Laravel + Filament)

A simplified multi-tenant Form Builder SaaS (similar to Google Forms) built using Laravel and Filament.

This project demonstrates skills in:

Multi-Tenancy Architecture

Database Design

Dynamic Form Builder Logic

Filament Admin Customization

Public Form Rendering

Team Management & Roles

Data Collection & Results Visualization

🔗 Live Demo:
👉 https://formk.mhmud.com

🎯 Project Objective

Build a scalable, tenant-based system where each company (tenant) can:

Create dynamic forms

Share public form links

Collect submissions

Manage team members

View and analyze results

Each tenant is fully isolated from others.

🏗️ Architecture Overview
🧠 Multi-Tenant Strategy

A single database with tenant_id applied to all tenant-related models.

Each user belongs to one tenant

All forms, fields, and submissions are tenant-scoped

Team members only see their tenant’s data

No heavy tenancy packages were used — simple and clean architecture.

📝 Core Features
1️⃣ Authentication & Tenant Registration

Public registration page

On registration:

User is created

Tenant (workspace) is automatically created

User becomes Owner

Login handled via standard Laravel auth

2️⃣ Form Builder

A minimal but powerful form builder implemented using Filament.

🔹 Supported Field Types

Text

Number

Long Text

Dropdown

Checkbox

File Upload

Date

🔹 Form Capabilities

Create & edit forms

Add fields dynamically

Reorder fields (drag & drop / arrows)

Group fields into Sections

Configure field properties:

Title

Placeholder / Hint

Required (true / false)

Dropdown options

Save as Draft

Publish form → generate public URL

Built using Filament Builder / Repeater components.

3️⃣ Public Form Rendering

Published forms are accessible via public link

No authentication required

Fields render exactly as configured

Supports:

Required validation

File uploads

Submissions are saved securely in the database

4️⃣ Form Submissions & Results Viewer

Inside the Filament dashboard:

Each form has a Results Page

Submissions displayed in a table:

Columns = Form fields

Rows = Submissions

Similar to Excel-style view

Fully tenant-scoped data

📌 (CSV export can be added easily if needed)

5️⃣ Team Management & Roles

Tenant owner can manage team members.

👥 Roles
Role	Permissions
Owner	Full access
Staff	Create forms & view results
Features

Add team members (name, email, role)

Team members login normally

Role-based access enforced

Staff cannot delete tenant or users

🗄️ Database Design (Simplified)
Tenants


Users


Forms


form Results

🧰 Tech Stack

Laravel

Filament Admin Panel

MySQL

Blade

Laravel Storage (File Uploads)

🔐 Security Notes

Tenant isolation enforced at query level

Public forms are read-only

Submissions validated server-side

Role-based access control

🚀 Ideal Use Cases

Internal company surveys

Client feedback forms

HR forms

Lead collection

MVP SaaS form builder

👨‍💻 Author

Mahmoud Elsayed
Backend Developer – Laravel

🔗 Demo: https://formk.mhmud.com
