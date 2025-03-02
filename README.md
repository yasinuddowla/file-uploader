# File Upload API Documentation

This API allows clients to upload files to a server, storing them in a configurable directory. It uses Bearer token authentication for security.

## Base URL

-   Will be provided by the API administrator.

## Endpoint

### Upload a File

Uploads a file to the server.

-   **Method**: `POST`
-   **Path**: `/bmd-data`
-   **URL**: `http://{{baseurl}}/api/bmd-data`

#### Headers

| Header          | Value                 | Required | Description                     |
| --------------- | --------------------- | -------- | ------------------------------- |
| `Authorization` | `Bearer <secret-key>` | Yes      | Bearer token for authentication |
| `Content-Type`  | `multipart/form-data` | Yes      | Required for file uploads       |

#### Request Body

| Field  | Type | Required | Description                   |
| ------ | ---- | -------- | ----------------------------- |
| `file` | File | Yes      | The file to upload (max 10MB) |

#### Example Request (cURL)

```bash
curl -X POST http://{{baseurl}}/api/bmd-data \
  -H "Authorization: Bearer your_fixed_secret_key_here" \
  -F "file=@/path/to/your/file.nc"
```

-   Replace `your_fixed_secret_key_here` with the secret key provided by the API administrator.
-   Replace `/path/to/your/file.nc` with the path to your file.

#### Success Response

-   **Status Code**: `201 Created`
-   **Body**:
    ```json
    {
        "message": "File uploaded successfully",
        "path": "/srv/data/1638321234_file.nc"
    }
    ```
    -   `path`: The full server path where the file is stored (e.g., `/srv/data/<timestamp>_<original-filename>`).

#### Error Responses

1. **Unauthorized (Invalid or Missing Token)**

    - **Status Code**: `401 Unauthorized`
    - **Body**:
        ```json
        {
            "message": "Unauthorized"
        }
        ```

2. **Validation Error (Missing or Invalid File)**

    - **Status Code**: `422 Unprocessable Entity`
    - **Body** (example):
        ```json
        {
            "message": "The file must be a file of type: nc",
            "errors": {
                "file": ["The file must be a file of type: nc"]
            }
        }
        ```

3. **Server Error**
    - **Status Code**: `500 Internal Server Error`
    - **Body** (example):
        ```json
        {
            "message": "File upload failed",
            "error": "Permission denied"
        }
        ```

## Authentication

-   **Type**: Bearer Token
-   **Key**: A fixed secret key stored in the server’s configuration.
-   **How to Obtain**: Contact the API administrator for the secret key.
-   **Usage**: Include the key in the `Authorization` header as `Bearer <secret-key>`.

## File Requirements

-   **Format**: NetCDF (extension: `.nc`)
-   **Max Size**: 10MB (configurable by the server administrator)

## Notes

-   **Storage Location**: Files are saved to a directory specified in the server’s configuration (default: `/srv/data/`).
-   **Security**: Use HTTPS in production to encrypt the token and file data.
-   **Rate Limiting**: Not implemented (contact the administrator if needed).

## Troubleshooting

-   **“Unauthorized” Error**: Ensure the `Authorization` header is correct and matches the secret key.
-   **“File type” Error**: Verify the uploaded file has a extension and is a valid NetCDF file.
-   **“File too large” Error**: Check that the file size is under 10MB.

## Contact

For support or to obtain the secret key, please contact the API administrator.
