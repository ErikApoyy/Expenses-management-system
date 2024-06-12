# Assignment 2

Public URL: https://ictteach-www.its.utas.edu.au/groupwork/kit502-group-24/Assignment-2/public/

Database Schema with description is defined below, you can also find the schema in "database/migrations/" folder.

## Login Details

You can login using following details;

### Staff One
```
Email: staff1@example.com
Password: P@S5W0rD
```

Staff One is assigned to "Manager One". Expenses submitted by Staff One will only be shown to Manager One first, then to H.O.D.

### Staff Two

```
Email: staff2@example.com
Password: P@S5W0rD
```

Staff Two is assigned to "Manager Two". Expenses submitted by Staff Two will only be shown to Manager Two first, then to H.O.D.


### Manager One

```
Email: manager1@example.com
Password: P@S5W0rD
```

### Manager Two

```
Email: manager2@example.com
Password: P@S5W0rD
```

### Head of Department

```
Email: hod@example.com
Password: P@S5W0rD
```

### System Manager

```
Email: admin@example.com
Password: P@S5W0rD
```

## Database Schema

We make use of total of three database tables (and Model).

### User / Table name: `users`

- **id** -> Primary ID
- **name** -> string
- **email** -> string, unique
- **password** -> string
- **department_id** -> foreign ID related to `departments` table. 
- **position** -> can be 'STAFF', 'MANAGER', 'HEAD OF DEPARTMENT' or 'SYSTEM MANAGER'
- **manager_id** -> nullable foreign ID, only for position 'STAFF' denoting who their manager are. Foreign ID for self, i.e `users` table's ID column.

### Department / Table Name: `departments`

- **id* -> Primary ID
- **name** -> String

### Expense / Table Name: `expenses`

- **id** -> primary ID
- **user_id** -> ID of staff or manager who submitted the expense. Foreign ID for `users` table.
- **amount** - Decimal(10, 2)
- **description** - Text, description for expense.
- **category** - String, category of the expense.
- **document** -> String, path of file submitted.
- **is_active** -> tinyint(1) / boolean - "false" marks it as draft. Default value: false
- **status_manager** -> String, holds status 'Submitted', 'Approved', or 'Rejected' given by direct manager.
- **remarks_manager** -> String, nullable, for storing remarks given by manager when approving or rejecting the submission.
- **status_hod** -> String, holds status 'Submitted' (default), 'Approved', or 'Rejected' given by Head of Department (HOD)
- **remarks_hod** -> String, nullable, for storing remarks given by manager when approving or rejecting the submission.
