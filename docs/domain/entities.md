# Entities

## User
- ID (int)
- Name (string)
- Email (string)
- Password (string)

## Account
- ID (int)
- UserID (int)
- Name (string)
- Balance (float)
- Currency (string)

## Category
- ID (int)
- Name (string)
- Type (string: income|expense)

## Transaction
- ID (int)
- UserID (int)
- AccountID (int)
- CategoryID (int)
- Amount (float)
- Type (string: income|expense)
- Date (datetime)
- Description (string)
