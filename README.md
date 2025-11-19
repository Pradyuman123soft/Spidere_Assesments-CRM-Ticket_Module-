# 🎫 CRM - Ticket Management System  
A simple PHP-based Ticket Management System built as an assessment project.  
The system allows users to register, login, create tickets, assign tickets, update statuses, and manage ticket lifecycle.

---

## 🚀 Features

### 🔐 Authentication
- User Registration  
- User Login  
- Secure Password Hashing (password_hash / password_verify)  
- Session Handling  

### 🎟 Ticket Management
- Create Ticket  
- Edit Ticket  
- File Upload Support  
- Status Management  
  - pending  
  - inprogress  
  - onhold  
  - completed 

### 👥 Assignment Module
- Assign ticket to any registered user  
- Track assigned user and assigned_at time

### 🛡 Role-based Permissions
- **Author (Ticket Creator)**  
  - Can update all ticket details
  - Can create tickets for user's
  - cannot see other author assigned tickets

- **Assignee (Assigned User)**  
  - Can update ticket status only  
  - Cannot update name, description, file, or assignment
  - cannot see other Assignee tickets

---

