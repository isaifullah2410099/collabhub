# UIU CollabHub

UIU CollabHub is a simple student collaboration class project made with HTML, CSS, JavaScript, PHP and MySQL/MariaDB.

Students can register, login, post personal projects/research/freelance gigs, search by skills, send proposals, form teams and show portfolio work. An admin account can manage users and projects.

> This is a student class project and is not an official United International University website.

---

## Main Features

- Student registration with duplicate Student ID check
- Student login
- Forgot password using a security question
- Home page with recent projects
- Search and filter projects
- Post personal projects, research work, academic projects or freelance gigs
- Skills saved as comma-separated tags
- Send a proposal to join a project
- Project owner can accept or reject applicants
- Student dashboard
- Student profile and portfolio
- Admin dashboard
- Admin can edit/delete users
- Admin can edit/delete projects
- Demo students and projects are already included in `database.sql`

---

# Login

## Admin

Username: `admin`

Password: `1234`

## Demo User 1

Student ID: `011223344`

Password: `123456`

## Demo User 2

Student ID: `011223355`

Password: `123456`

## Demo User 3

Student ID: `011223366`

Password: `123456`

## Security Answer for Demo Users

`blue`

The security question is:

`What is your favourite color?`

---

# Method 1 - GitHub Codespaces

This project does **not** use npm, Node.js, React or a build command.



The project uses plain PHP and MariaDB.

## 1. Create a Codespace

On the GitHub repository page:

1. Click **Code**.
2. Click **Codespaces**.
3. Click **Create codespace on main**.
4. Wait for the container to finish building.

The `.devcontainer` setup installs:

- PHP
- the PHP `mysqli` extension
- MariaDB client
- Git LFS
- MariaDB database service
- the `uiu_collabhub` database
- the tables and demo data from `database.sql`

---

## 2. Commands to Run the Website

If you want to make sure PHP has `mysqli`, you can optionally run:

```bash
php -m | grep -i mysqli
```

Then check that the database tables are ready:

```bash
mysql -h db -u uiu -puiu123 uiu_collabhub -e "SHOW TABLES;"
```

Then start the website:

```bash
php -S 0.0.0.0:8000
```

Open the **Ports** tab in Codespaces and open port **8000**.

To stop the PHP server, press:

```text
Ctrl + C
```

---

## 3. If You Want to Reload `database.sql`

If the database is already running and you want to load the SQL file manually:

```bash
mysql -h db -u uiu -puiu123 uiu_collabhub < database.sql
```

The demo users use `INSERT IGNORE`, so importing the file again will not create duplicate demo users with the same IDs.

For a completely fresh database, creating a new Codespace is usually easiest.

---

# Saving and Pushing Changes to GitHub

If Git says `git-lfs` was not found, run these first:

```bash
sudo apt-get update
sudo apt-get install -y git-lfs
```

The new Dockerfile already installs Git LFS automatically, but the commands above are useful if an older Codespace was created before that change.

Then save your changes with:

```bash
git add .
git commit -m "describe what you changed"
git push
```

Then check the repository status:

```bash
git status
```

A clean result should look similar to:

```text
On branch main
Your branch is up to date with 'origin/main'.

nothing to commit, working tree clean
```

---

# Normal Codespaces Routine

After the project has already been set up, the normal routine is simply:

```bash
php -S 0.0.0.0:8000
```

Then open port `8000`.

When you finish editing:

```bash
git add .
git commit -m "describe what you changed"
git push
git status
```

You normally do **not** need to rebuild the container every time.

---

# Method 2 - XAMPP on Windows

## 1. Copy the Project

Copy the project folder into:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\uiu-collabhub\
```

## 2. Start XAMPP

Open XAMPP Control Panel and start:

- Apache
- MySQL

## 3. Import the Database

Open:

```text
http://localhost/phpmyadmin
```

Then:

1. Click **Import**.
2. Select `database.sql`.
3. Run the import.

The file creates the database, tables and demo data.

## 4. Open the Website

Open:

```text
http://localhost/uiu-collabhub/
```

For XAMPP, `db.php` uses these defaults:

- Host: `localhost`
- User: `root`
- Password: empty
- Database: `uiu_collabhub`

---

# Database Tables

The project uses four main tables:

1. `users`
2. `projects`
3. `applications`
4. `portfolio`

---

# Files to Understand First

For the class presentation, read these files first:

1. `index.php` - student/admin login
2. `register.php` - registration and duplicate Student ID check
3. `db.php` - database connection
4. `home.php` - student home page
5. `projects.php` - search/filter projects
6. `create_project.php` - create a project
7. `project_details.php` - project information and proposal form
8. `apply.php` - save a proposal
9. `manage_applications.php` - project owner views applicants
10. `update_application.php` - accept/reject applicant
11. `dashboard.php` - projects and applications for the logged in student
12. `profile.php` - profile and portfolio
13. `admin_users.php` - admin user management
14. `admin_projects.php` - admin project management
15. `style.css` - the shared website design

---

# Design Notes

The interface uses:

- Inter font with Arial/Helvetica fallback
- pure white background
- UIU orange `#ff5a14` as the main accent
- simple neutral borders
- no glassmorphism
- no orange drop shadows
- editorial navigation and typography
- search-first project discovery
- vertical project listings instead of dashboard-style bento cards

---

# Class Project Notes

- Important sections have simple comments in the PHP files.
- The backend intentionally uses basic `mysqli`, `if/else`, `$_POST`, `$_GET`, loops and normal SQL queries.
- Student passwords and security answers are stored using PHP `password_hash()`.
- The admin login is intentionally hard-coded for the classroom demo only.

<!--
git add .devcontainer/Dockerfile
git commit -m "Install Git LFS in Codespaces"
git push
-->
