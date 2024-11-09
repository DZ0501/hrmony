# Sprint Plan: HRMony
**Overview**

The goal of this sprint is to build the foundational features of the recruitment and employee management system in two weeks, with a focus on user roles, job applications, and employee profiles.

---

## Sprint Breakdown

### Week 1: Setup and Basic Authentication

- **Day 1**: 
  - Set up database structure and finalize role management using Spatie.
  - Establish model relationships: `User` -> `JobApplication`, `User` -> `EmployeeDetail`.
  
- **Day 2**:
  - Implement API-based authentication with role-based access using middleware.
  - Create custom middlewares for roles (e.g., `Admin`, `HR`).

- **Day 3**:
  - Start recruitment module by setting up `JobApplicationController`.
  - Create basic routes for submitting and viewing job applications, with access control.

### Week 2: Recruitment Module Completion and Employee Area

- **Day 4**: 
  - Build token-based system for job application access.
  - Write middleware to validate tokens and restrict access accordingly.
  
- **Day 5**:
  - Implement email notifications to send job application links with tokens.
  - Add application status updates and control access to this functionality.

- **Day 6**:
  - Set up `EmployeeDetailController` and basic employee profile viewing.
  - Implement access control for employee profiles.

---

## Progress Tracking

### Week 1
- [ ] Database and role management setup completion
- [ ] Authentication and middleware implementation
- [ ] Recruitment module initial setup

### Week 2
- [ ] Token-based system for applications
- [ ] Email notifications for application links
- [ ] Employee area and profile management
