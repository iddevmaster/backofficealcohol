# API Documentation — Device Integration

**Base URL:** `http://<your-server>/api`  
**Version:** 1.0  
**Authentication:** Laravel Sanctum — Bearer Token

---

## Authentication

All device endpoints require a **Sanctum Personal Access Token** sent in the `Authorization` header.

```
Authorization: Bearer <your_token>
Accept: application/json
```

### Generating a Token (Admin)

Run in `php artisan tinker` or from the admin panel:

```php
$user = App\Models\User::find(1);
$token = $user->createToken('device-kiosk-01')->plainTextToken;
// Store this token securely on the device
```

### Error — No Token / Invalid Token

**Status:** `401 Unauthorized`

```json
{
    "message": "Unauthenticated."
}
```

---

## Endpoints

### 1. Get Employee

Retrieve employee data including fingerprints by employee code.

---

**`GET /api/device/employee/{org_id}/{emp_id}`**

#### Path Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `org_id` | string | ✓ | Organization UUID |
| `emp_id` | string | ✓ | Employee numeric sequence (e.g., `001`) |

> **Note:** The API retrieves the `org_code` (e.g., `TSMC`) from the organization and concatenates it with `emp_id` (e.g., `001`) to find the employee (e.g., `TSMC001`).

#### Request Headers

| Header | Value |
|---|---|
| `Authorization` | `Bearer <token>` |
| `Accept` | `application/json` |

#### Response `200 OK`

```json
{
    "success": true,
    "data": {
        "id": 1,
        "emp_id": "EMP001",
        "full_name": "นาย สมชาย ใจดี",
        "status": true,
        "org_id": 1,
        "fingerprints": [
            {
                "id": 1,
                "finger_no": 1,
                "fingerprint_code": "AQAAAE4RUgBgAAAA..."
            },
            {
                "id": 2,
                "finger_no": 2,
                "fingerprint_code": "BwAAAC8RAAB0AAAA..."
            }
        ]
    }
}
```

| Field | Type | Description |
|---|---|---|
| `data.id` | integer | Employee primary key (DB id) |
| `data.emp_id` | string | Employee code |
| `data.full_name` | string | Prefix + first name + last name |
| `data.status` | boolean | `true` = active, `false` = inactive |
| `data.org_id` | integer | Organization ID |
| `data.fingerprints` | array | List of registered fingerprints |
| `data.fingerprints[].id` | integer | Fingerprint record ID |
| `data.fingerprints[].finger_no` | integer | Finger index number |
| `data.fingerprints[].fingerprint_code` | string | Fingerprint template data |

#### Response `404 Not Found`

```json
{
    "success": false,
    "message": "Employee not found"
}
```

---

### 2. Store Test Data

Submit an alcohol test result from a device. The image file is saved to server storage; the path is recorded in the database.

---

**`POST /api/device/test`**

#### Request Headers

| Header | Value |
|---|---|
| `Authorization` | `Bearer <token>` |
| `Accept` | `application/json` |
| `Content-Type` | `multipart/form-data` |

#### Request Body (`multipart/form-data`)

| Field | Type | Required | Validation | Description |
|---|---|---|---|---|
| `emp_id` | string | ✓ | max 191 chars, must match a valid employee | Employee code (e.g., `EMP001`) |
| `device_sn` | string | ✓ | max 191 chars | Device serial number |
| `alcohol_level` | float | ✓ | numeric, min: 0 | Alcohol level reading |
| `testing_image` | file | ✓ | image file, allowed types: jpeg/png/jpg/gif/bmp/webp, max 10MB | Photo captured during test |
| `testing_date` | string | ✓ | format: `Y-m-d H:i:s` | Date and time of test |
| `org_id` | integer | ✓ | must exist in `organizations` table | Organization ID |

> **Note:** `emp_id` is the employee code string. The API resolves the internal employee PK (`tester_id`) automatically.

#### Response `201 Created`

```json
{
    "success": true,
    "message": "Test data stored successfully",
    "data": {
        "id": 42,
        "tester_id": 1,
        "device_sn": "BRZ-2024-001",
        "alcohol_level": 0.15,
        "testing_image": "test-images/AbCdEfGh1234xyz.jpg",
        "testing_date": "2026-05-06 13:30:00",
        "org_id": 1
    }
}
```

| Field | Type | Description |
|---|---|---|
| `data.id` | integer | Created record ID |
| `data.tester_id` | integer | Employee primary key (resolved internally from `emp_id`) |
| `data.device_sn` | string | Device serial number |
| `data.alcohol_level` | float | Alcohol level reading |
| `data.testing_image` | string | File path in storage (relative to `storage/app/public/`) |
| `data.testing_date` | string | Test datetime |
| `data.org_id` | integer | Organization ID |

> **Accessing the image:** `GET /storage/{testing_image}`  
> Example: `GET /storage/test-images/AbCdEfGh1234xyz.jpg`

#### Response `404 Not Found` — Employee not found

```json
{
    "success": false,
    "message": "Employee not found"
}
```

#### Response `422 Unprocessable Entity` — Validation failed

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "emp_id": ["The emp id field is required."],
        "testing_image": ["The testing image must be an image."],
        "testing_date": [
            "The testing date does not match the format Y-m-d H:i:s."
        ]
    }
}
```

---

## Error Reference

| HTTP Status | Meaning |
|---|---|
| `200 OK` | Request succeeded (GET) |
| `201 Created` | Resource successfully created (POST) |
| `401 Unauthorized` | Missing or invalid Bearer token |
| `404 Not Found` | Employee with given `emp_id` does not exist |
| `422 Unprocessable Entity` | Validation failed — check `errors` field |
| `500 Internal Server Error` | Server error |

---

## Example — cURL

### Get Employee

```bash
curl -X GET "http://<server>/api/device/employee/991a03e1-381d-4f1b-a9a3-5c8c1d85b99a/001" \
  -H "Authorization: Bearer <your_token>" \
  -H "Accept: application/json"
```

### Store Test Data

```bash
curl -X POST "http://<server>/api/device/test" \
  -H "Authorization: Bearer <your_token>" \
  -H "Accept: application/json" \
  -F "emp_id=EMP001" \
  -F "device_sn=BRZ-2024-001" \
  -F "alcohol_level=0.00" \
  -F "testing_date=2026-05-07 09:30:00" \
  -F "org_id=1" \
  -F "testing_image=@/path/to/photo.jpg"
```

---

## File Storage

Uploaded test images are stored at:

```
storage/app/public/test-images/
```

Ensure the public disk link is created:

```bash
php artisan storage:link
```

Public access URL format:

```
http://<server>/storage/test-images/<filename>
```
