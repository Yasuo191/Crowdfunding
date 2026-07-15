# Crowdfunding System API Specification

## Overview

This document describes the REST API endpoints used by the Crowdfunding System.

### Base URL

```
http://localhost/crowdfunding/backend/api/
```

### Content Type

All POST requests use:

```
multipart/form-data
```

or

```
application/x-www-form-urlencoded
```

All responses are returned in JSON format.

---

# Authentication

## Register

### Endpoint

```
POST /register.php
```

### Description

Create a new user account.

### Request Parameters

| Name | Type | Required | Description |
|------|------|----------|-------------|
| username | string | Yes | Username |
| email | string | Yes | Email address |
| password | string | Yes | User password |

### Success Response

```json
{
    "success": true,
    "message": "Đăng ký thành công"
}
```

### Error Response

```json
{
    "success": false,
    "message": "Tên đăng nhập đã tồn tại"
}
```

---

## Login

### Endpoint

```
POST /login.php
```

### Description

Authenticate user and create session.

### Request Parameters

| Name | Type | Required |
|------|------|----------|
| username | string | Yes |
| password | string | Yes |

### Success Response

```json
{
    "success": true,
    "message": "Đăng nhập thành công",
    "user": {
        "id": 1,
        "username": "admin",
        "role": "admin"
    }
}
```

---

## Logout

### Endpoint

```
POST /logout.php
```

### Description

Destroy current session.

---

# Campaign

## Get Campaign List

### Endpoint

```
GET /campaign_list.php
```

### Description

Return all visible campaigns.

### Success Response

```json
[
    {
        "id": 1,
        "title": "Support Children",
        "target_amount": 10000000,
        "current_amount": 2500000,
        "status": "active"
    }
]
```

---

## Get Campaign Detail

### Endpoint

```
GET /campaign_detail.php?id={id}
```

### Description

Return detailed information of one campaign.

---

## Create Campaign

### Endpoint

```
POST /create_campaign.php
```

### Description

Create a new crowdfunding campaign.

### Request Parameters

| Name | Type |
|------|------|
| title | string |
| description | text |
| target_amount | number |
| start_date | date |
| end_date | date |
| image | file |

### Success Response

```json
{
    "success": true,
    "message": "Tạo chiến dịch thành công"
}
```

---

## Update Campaign

### Endpoint

```
POST /update_campaign.php
```

### Description

Update campaign information.

### Request Parameters

| Name | Type |
|------|------|
| id | integer |
| title | string |
| description | text |
| target_amount | number |
| start_date | date |
| end_date | date |
| image | file (optional) |

### Success Response

```json
{
    "success": true,
    "message": "Cập nhật thành công"
}
```

---

## Delete / Hide Campaign

### Endpoint

```
POST /delete_campaign.php
```

### Description

Hide a campaign instead of permanently deleting it.

### Request Parameters

| Name | Type |
|------|------|
| id | integer |

---

# Donation

## Donate

### Endpoint

```
POST /donate.php
```

### Description

Donate to a campaign.

### Request Parameters

| Name | Type |
|------|------|
| campaign_id | integer |
| amount | number |
| message | string |

### Success Response

```json
{
    "success": true,
    "message": "Quyên góp thành công"
}
```

---

## Donation History

### Endpoint

```
GET /my_donations.php
```

### Description

Return donation history of current user.

---

# Comment

## Get Comments

### Endpoint

```
GET /get_comments.php
```

### Description

Return all comments of a campaign.

### Parameters

| Name | Type |
|------|------|
| campaign_id | integer |

---

## Add Comment

### Endpoint

```
POST /add_comment.php
```

### Description

Create a new comment.

### Parameters

| Name | Type |
|------|------|
| campaign_id | integer |
| content | string |

---

# Favorite

## Add / Remove Favorite

### Endpoint

```
POST /toggle_favorite.php
```

### Description

Toggle favorite status of a campaign.

### Parameters

| Name | Type |
|------|------|
| campaign_id | integer |

---

## Get Favorite List

### Endpoint

```
GET /favorites.php
```

### Description

Return all favorite campaigns of current user.

---

# Dashboard

## My Dashboard

### Endpoint

```
GET /dashboard.php
```

### Description

Return dashboard summary including:

- Total campaigns
- Total donations
- Total raised amount

---

## My Campaigns

### Endpoint

```
GET /my_campaigns.php
```

### Description

Return all campaigns created by current user.

---

# Admin

## Dashboard

### Endpoint

```
GET /admin_dashboard.php
```

### Description

Return administrator dashboard statistics.

---

## Approve Campaign

### Endpoint

```
POST /approve_campaign.php
```

### Description

Approve a pending campaign.

---

## Hide Campaign

### Endpoint

```
POST /delete_campaign.php
```

### Description

Hide a campaign from public users.

---

# Response Format

## Success

```json
{
    "success": true,
    "message": "Operation completed successfully"
}
```

## Failed

```json
{
    "success": false,
    "message": "Error description"
}
```

---

# Authentication

The backend uses PHP Session Authentication.

Protected endpoints require a valid authenticated session.

Users are assigned one of the following roles:

- User
- Admin

---

# HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 500 | Internal Server Error |

---

# Technologies

- React 19
- Vite
- PHP 8
- MySQL
- Axios
- XAMPP

---

# Project Structure

```
Frontend (React)
        │
        │ Axios
        ▼
Backend API (PHP)
        │
Controllers
        │
Services
        │
Models
        │
PDO
        │
MySQL Database
```