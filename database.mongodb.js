
// Jalankan "use news_app" di termial mongodb

use('news_app');

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
                    description: "Update timestamp is optional."
                },
                image: {
                    bsonType: "binData",
                    description: "Image is optional and must be binary data."
                },
                jumlah_views: {
                    bsonType: "int",
                    description: "View count is optional and must be an integer."
                }
            }
        }
    }
});


// Create COLLECTION COMMENTS
db.createCollection("comments", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["id_news", "comment"],
            properties: {
                id_news: {
                    bsonType: "objectId",
                    description: "ID of the related news is required and must be an ObjectId."
                },
                comment: {
                    bsonType: "string",
                    description: "Comment is required and must be a string."
                },
                created_at: {
                    bsonType: "date",
                    description: "Creation timestamp is optional and must be a date."
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

javascript
db.createCollection("notifications", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["message", "created_at"],
            properties: {
                message: {
                    bsonType: "string",
                    description: "Notification message is required and must be a string."
                },
                created_at: {
                    bsonType: "date",
                    description: "Creation timestamp is required."
                },
                is_read: {
                    bsonType: "bool",
                    description: "Indicates if the notification is read."
                }
            }
        }
    }
});

db.news.aggregate([
    {
        $group: {
            _id: "$category",
            total_views: { $sum: "$jumlah_views" }
        }
    },
    {
        $sort: { total_views: -1 } 
    }
]);






