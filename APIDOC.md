## Construction Stages API

This API is used to manage construction stages. Below are the available endpoints of the API along with the request and response formats required for these endpoints.

### Endpoints

---

#### 1. Get All Construction Stages

```
GET /constructionStages
```

**Description:**
This endpoint retrieves all construction stages.

**Parameters:**
None

**Sample Request:**
```
GET /constructionStages
```

**Sample Response:**
```json
[
    {
        "id": 1,
        "name": "Foundation Laying",
        "startDate": "2024-02-01T08:00:00Z",
        "endDate": "2024-02-10T17:00:00Z",
        "duration": 9,
        "durationUnit": "DAYS",
        "color": "#FF0000",
        "externalId": "abc123",
        "status": "PLANNED"
    },
    {
        "id": 2,
        "name": "Wall Construction",
        "startDate": "2024-02-12T08:00:00Z",
        "endDate": "2024-02-25T17:00:00Z",
        "duration": 13,
        "durationUnit": "DAYS",
        "color": "#00FF00",
        "externalId": "def456",
        "status": "NEW"
    }
]
```

---

#### 2. Get a Specific Construction Stage

```
GET /constructionStages/{id}
```

**Description:**
This endpoint retrieves a specific construction stage.

**Parameters:**
- `id` (path param): The identifier of the construction stage

**Sample Request:**
```
GET /constructionStages/1
```

**Sample Response:**
```json
{
    "id": 1,
    "name": "Foundation Laying",
    "startDate": "2024-02-01T08:00:00Z",
    "endDate": "2024-02-10T17:00:00Z",
    "duration": 9,
    "durationUnit": "DAYS",
    "color": "#FF0000",
    "externalId": "abc123",
    "status": "PLANNED"
}
```

---

#### 3. Create a New Construction Stage

```
POST /constructionStages
```

**Description:**
This endpoint creates a new construction stage.

**Parameters:**
- `name` (body param, required for create, optional for update): The name of the construction stage
- `startDate` (body param, required for create, optional for update): The start date and time of the construction stage (in ISO 8601 format)
- `endDate` (body param, optional default null): The end date and time of the construction stage (in ISO 8601 format)
- `durationUnit` (body param, optional default is DAYS): The unit of duration for the construction stage (HOURS, DAYS, WEEKS)
- `color` (body param, optional default null): The color of the construction stage (in HEX format)
- `externalId` (body param, optional default null): The external identifier of the construction stage (up to 255 characters)
- `status` (body param, optional for create default NEW, required for update): The status of the construction stage (NEW, PLANNED, DELETED)

**Sample Request:**
```json
POST /constructionStages
{
    "name": "Wall Construction",
    "startDate": "2024-02-12T08:00:00Z",
    "endDate": "2024-02-25T17:00:00Z",
    "durationUnit": "DAYS",
    "color": "#00FF00",
    "externalId": "def456",
    "status": "NEW"
}
```

**Sample Response:**
```json
{
    "id": 3,
    "name": "Wall Construction",
    "startDate": "2024-02-12T08:00:00Z",
    "endDate": "2024-02-25T17:00:00Z",
    "duration": 13,
    "durationUnit": "DAYS",
    "color": "#00FF00",
    "externalId": "def456",
    "status": "NEW"
}
```

---

#### 4. Update a Construction Stage

```
PATCH /constructionStages/{id}
```

**Description:**
This endpoint updates a specific construction stage.

**Parameters:**
- `id` (path param): The identifier of the construction stage
- Other parameters (body params): The fields to be updated along with their new values

**Sample Request:**
```json
PATCH /constructionStages/1
{
    "status": "PLANNED"
}
```

**Sample Response:**
```json
{
    "id": 1,
    "name": "Foundation Laying",
    "startDate": "2024-02-01T08:00:00Z",
    "endDate": "2024-02-10T17:00:00Z",
    "duration": 9,
    "durationUnit": "DAYS",
    "color": "#FF0000",
    "externalId": "abc123",
    "status": "PLANNED"
}
```

---

#### 5. Delete a Construction Stage

```
DELETE /constructionStages/{id}
```

**Description:**
This endpoint deletes a specific construction stage.

**Parameters:**
- `id` (path param): The identifier of the construction stage

**Sample Request:**
```
DELETE /constructionStages/1
```

**Sample Response:**
```json
{ "message": "Operation completed successfully" }
```

---

### Error Responses

- 400: Invalid request parameters.
- 404: The requested resource was not found.
- 500: Server error.

---