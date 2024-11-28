
// Jalankan "use news_app" di termial mongodb

use ('news_app')

// BUAT COLLECTION NEWS
db.createCollection("news", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["title", "content", "author", "category", "created_at"],
            properties: {
                title: {
                    bsonType: "string",
                    description: "Title is required and must be a string."
                },
                content: {
                    bsonType: "string",
                    description: "Content is required and must be a string."
                },
                summary: {
                    bsonType: "string",
                    description: "Summary is optional and must be a string."
                },
                author: {
                    bsonType: "string",
                    description: "Author name is required and must be a string."
                },
                category: {
                    bsonType: "string",
                    description: "Category is required and must be a string."
                },
                created_at: {
                    bsonType: "date",
                    description: "Creation timestamp is required."
                },
                updated_at: {
                    bsonType: "date",
                    description: "Update timestamp is required."
                }
            }
        }
    }
});

// BUAT COLLECTION USER
db.createCollection("users", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["username", "password", "created_at"],
            properties: {
                username: {
                    bsonType: "string",
                    description: "Username is required and must be a string."
                },
                password: {
                    bsonType: "string",
                    description: "Password is required and must be hashed."
                },
                created_at: {
                    bsonType: "date",
                    description: "Creation timestamp is required."
                }
            }
        }
    }
});
