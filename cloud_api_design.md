# Cloud API Design Document

This document defines the API surface required on the Cloud Server to support the Alcohol Testing Kiosk system.

## Authentication
All requests must include a Bearer token in the header:
`Authorization: Bearer <your_cloud_api_token>`

---

## 1. Employee Synchronization
Used by the kiosk to maintain a local cache of employee data for offline identification.

### **GET** `/device/employees/{org_id}`

**Path Parameters:**
- `org_id`: UUID (The organization the kiosk belongs to)

**Query Parameters:**
- `updated_since`: (Optional) ISO 8601 Timestamp. If provided, returns only employees updated after this time (incremental sync).

**Response (Success):**
Returns a list of employees. The system handles both a plain array `[...]` or a Laravel-style `{"data": [...]}` object.

```json
[
  {
    "id": "uuid-1",
    "emp_id": "EMP123",
    "full_name": "John Doe",
    "org_id": "org-uuid",
    "updated_at": "2024-05-14T08:00:00Z",
    "fingerprints": [
      {
        "id": "fp-uuid-1",
        "finger_index": 0,
        "fingerprint_code": "BASE64_ENCODED_TEMPLATE...",
        "updated_at": "2024-05-14T08:00:00Z"
      }
    ]
  }
]
```

---

## 2. Result Submission
Used by the kiosk to report test results and identification activity.

### **POST** `/device/scans/{org_id}`

**Path Parameters:**
- `org_id`: UUID

**Request Body:**
| Field | Type | Description |
| :--- | :--- | :--- |
| `device_id` | String | Unique identifier for the kiosk (e.g., Serial Number). |
| `employee_id` | String | UUID of the employee (not the `emp_id` string). |
| `scan_type` | String | One of: `"alcohol"`, `"fingerprint"`, `"identification"`. |
| `result` | String | Outcome: `"pass"`, `"fail"`, `"match"`, `"no_match"`, `"identified"`. |
| `value` | Float | (Optional) The alcohol measurement value (BAC). `null` for others. |
| `scanned_at` | String | ISO 8601 Timestamp of when the event occurred on the device. |

**Example Request:**
```json
{
  "device_id": "ALT-KIOSK-001",
  "employee_id": "uuid-1",
  "scan_type": "alcohol",
  "result": "pass",
  "value": 0.00,
  "scanned_at": "2024-05-14T09:30:00Z"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Scan result recorded",
  "id": "cloud-record-id-123"
}
```

---

## 3. Device Management
Used by the kiosk to register its hardware identifiers and maintain an active connection status with the cloud.

### **POST** `/device/register`

**Request Body:**
| Field | Type | Description |
| :--- | :--- | :--- |
| `serial_num` | String | Hardware serial number or UUID. |
| `ip_address` | String | Current local IP address of the kiosk. |
| `mac_address` | String | MAC address of the kiosk's primary network interface. |

**Example Request:**
```json
{
  "serial_num": "0000000012345678",
  "ip_address": "192.168.1.50",
  "mac_address": "B8:27:EB:AA:BB:CC"
}
```

**Response (Success):**
Returns the master configuration data that the kiosk needs to operate and sync data.
```json
{
  "success": true,
  "data": {
    "org_id": "uuid-org-123",
    "org_code": "IDD",
    "device_id": "uuid-device-456",
    "status": "active"
  }
}
```

---

### **POST** `/device/heartbeat`

**Request Body:**
| Field | Type | Description |
| :--- | :--- | :--- |
| `device_id` | String | The `device_id` returned from the registration endpoint. |
| `status` | String | Current status of the device (e.g., `"online"`). |

**Example Request:**
```json
{
  "device_id": "uuid-device-456",
  "status": "online"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Heartbeat received"
}
```

---

## Error Handling
The Cloud API should use standard HTTP status codes:
- `200 OK`: Successful GET.
- `201 Created`: Successful POST.
- `401 Unauthorized`: Missing or invalid Bearer token.
- `404 Not Found`: Organization or resource not found.
- `422 Unprocessable Entity`: Validation failure (e.g., missing fields).
- `500 Internal Server Error`: Server-side crash.
