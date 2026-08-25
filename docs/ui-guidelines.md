# PRS NEXUS UI Guidelines

## Design Principle

This project is a complete UI/UX redesign, not just a visual refresh.

Codex is encouraged to rethink:

- Information architecture
- Navigation hierarchy
- Dashboard layouts
- User workflows
- Page organization
- Content hierarchy

The goal is to create a modern university management system that feels intuitive and task-oriented.

Navigation, page layouts, and content organization may be redesigned if they improve usability.

Do not preserve the current structure simply because it already exists.

## Product Mindset

Design every page as if PRS NEXUS were a real commercial university platform.

Do not expose database entities directly to users.

Instead, organize pages around user goals and workflows.

Every redesign should improve usability, reduce unnecessary steps, and create a more intuitive experience while preserving existing functionality.

## Project

PRS NEXUS is an Integrated Peer Management and Support System for PRS.

The redesign should feel like a modern university portal rather than a CRUD management system.

The system has three user roles:

- Public Visitor
- Member
- Administrator

Every redesign should prioritize usability over simply making pages look modern.

---

# Design Philosophy

PRS NEXUS should be:

- Clean
- Professional
- Friendly
- Student-oriented
- Easy to navigate
- Responsive
- Accessible

Every page should answer one question:

"What is the user trying to accomplish here?"

Design around tasks, not around database tables.

---

# Visual Style

Style:

- Modern University Portal
- Material Design 3 inspired
- Minimal
- Spacious
- Rounded corners
- Soft shadows

Avoid:

- Gaming UI
- Glassmorphism
- Heavy gradients
- Neon colors
- Dark theme as default

---

# Color Palette

Primary
#2563EB

Secondary
#0EA5E9

Success
#22C55E

Warning
#F59E0B

Danger
#EF4444

Background
#F8FAFC

Cards
White

Use blue as the primary identity throughout the application.

---

# Typography

Font:

Inter

Hierarchy:

Large page titles

Medium section titles

Comfortable body text

Consistent spacing

---

# Layout

Use:

- Responsive sidebar
- Sticky top navigation
- Spacious content area
- Rounded cards
- Consistent spacing

Desktop first.

Mobile friendly.

---

# Information Architecture

Navigation SHOULD be reorganized if a better structure exists.

Codex should not assume the existing navigation is optimal.

Feel free to redesign the information architecture while preserving all existing functionality.

Group features logically.

Example:

Dashboard

Organization
- Members
- Committee

Events
- Meetings
- Activities

Reports

System
- Settings

Account
- Profile
- Logout

---

# Public Portal

Purpose:

Introduce PRS and help visitors discover information.

Pages:

Home

Directory

The homepage should include:

- Hero
- About PRS
- Statistics
- Featured Members
- Upcoming Meetings
- Activities
- Call to Action

The directory should focus on searching and filtering information.

---

# Admin Portal

Purpose:

Help administrators manage the organization efficiently.

Dashboard should prioritize:

- Statistics
- Recent activities
- Upcoming meetings
- Quick actions

Management pages should focus on:

- Efficient CRUD
- Search
- Filters
- Status
- Pagination

---

# Member Portal

Purpose:

Help members complete their daily tasks.

The dashboard should NOT be a profile page.

The dashboard should contain:

- Welcome
- Membership Status
- Upcoming Meetings
- Upcoming Activities
- Announcements
- Quick Actions

Avoid displaying detailed personal information.

Profile information belongs on a dedicated Account page.

---

# Profile Page

The Profile page manages personal information.

Sections:

Personal Information

Academic Information

Contact Information

Account Security

Profile Photo

Users should edit their information here.

---

# Components

Create reusable components whenever appropriate.

Examples:

- Buttons
- Cards
- Badges
- Tables
- Alerts
- Empty States
- Forms
- Modals
- Avatar

Maintain visual consistency.

---

# UX Rules

Prefer cards over large tables where appropriate.

Place filters near the content they affect.

Keep actions close to related information.

Reduce unnecessary scrolling.

Every page should have one clear primary action.

Use meaningful empty states.

Use confirmation dialogs before destructive actions.

---

# Accessibility

Maintain good contrast.

Support keyboard navigation.

Use proper labels.

Design responsively.

Avoid relying only on colour.

---

# Laravel Rules

During the UI redesign, preserve backend functionality whenever possible.

After the UI redesign is complete, Codex may improve the Laravel architecture if it results in a cleaner, more maintainable application.

Allowed improvements:

- Reorganize routes
- Introduce RESTful resource routes
- Split large controllers into resource controllers
- Reorganize Blade views
- Improve navigation structure
- Create dedicated management pages
- Improve controller responsibilities

Restrictions:

- Preserve all existing features.
- Preserve authentication.
- Preserve the database schema unless absolutely necessary.
- Avoid breaking changes.
- Reuse existing models where possible.
- Maintain compatibility with the redesigned UI.

---

# Architecture Principles

The application should follow Laravel best practices.

Avoid placing unrelated features inside a single dashboard.

Each major module should have its own dedicated management experience.

Examples:

Admin

- Dashboard
- Member Management
- Committee Management
- Meeting Management
- Activity Management
- Reports
- Settings

Member

- Overview
- My Schedule
- Directory
- Account

Public

- Home
- Directory

The navigation and route structure should reflect these modules.

# Codex Instructions

Before redesigning a page:

1. Inspect the existing Blade file.
2. Understand its functionality.
3. Preserve backend behaviour.
4. Improve the UI and UX.
5. You may reorganize layouts, navigation, and information hierarchy if it improves usability.
6. Do not remove features.
7. Reuse Blade components whenever possible.
8. After completion, summarize the changes and list modified files.

Think like a Senior Product Designer, not just a Frontend Developer.
