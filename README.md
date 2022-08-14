##<p align="center">Itoll Book-Store Test</p>


## Install

This is a test app for Itoll company. please clone the project and define a database and config it in .env .then run these commands listed below:
- composer install
- php artisan migrate
- php artisan db:seed -> users table(book-stores) and books table and cards table will be filled.
- php artisan passport:install
- php artisan key:generate
- php artisan optimize
- php artisan serve

I wrote a single test for books index api just as sample. you can test it by running "php artisan test" command

## API's

### 1. api/login POST
    - parameters:
      - 1.email >  test@example.com 
        
      -  2.password > 12345678
    - response:
    {
       - "token_type": "Bearer",
       - "expires_in": 172800,
       - "access_token": "CJGREBNRFYMowA9vWuwfQFgkN_yaqVNMY-XecmQxXN-B6rw",
       - "refresh_token": "CJGREBNRFYMowA9vWuwfQFgkN_yaqVNMY-XecmQxXN-B6rw",
       - "user": {
       - "name": "test",
       - "email": "test@example.com",
       - "mobile": "09129120912"
       }
    }
### 2. api/revoke POST
     - Response
        - 'با موفقیت خارج شدید'

### 3. api/books GET
    - Response:
        - {
          - "data": [
              {
            - "id": 1,
            - "title": "Otho Hudson", 
            - "book_number": "ELHGTDTENY",
            - "price": "12923",
            - "quantity": 74,
            - "created_at": "2022-08-13T21:09:30.000000Z",
            - "updated_at": "2022-08-13T21:11:07.000000Z",
            - "deleted_at": null
            - },
            - {
            - "id": 2,
            - "title": "Dr. Judson Lehner II",
            - "book_number": "89WWF4GGYP",
            - "price": "11076",
            - "quantity": 39,
            - "created_at": "2022-08-13T21:09:30.000000Z",
            - "updated_at": "2022-08-13T21:09:30.000000Z",
            - "deleted_at": null
          - },

### 4. api/order POST
    - Parameters:
        - title: Otho Hudson
        - book_number: ELHGTDTENY
        - amount: 20
    - Response:
        - {
            - "data": {
                - "user_id": 1,
                - "book_id": 1,
                - "order_number": "UYESAUFNKV",
                - "quantity": "20",
                - "price": 258460,
                - "book": {
                - "id": 1,
                - "title": "Otho Hudson",
                - "book_number": "ELHGTDTENY",
                - "price": "12923",
                - "quantity": 74,
                - "created_at": "2022-08-13T21:09:30.000000Z",
                - "updated_at": "2022-08-13T21:11:07.000000Z",
                - "deleted_at": null
                - },
                - "updated_at": "2022-08-14T20:31:33.000000Z",
                - "created_at": "2022-08-14T20:31:33.000000Z",
                - "id": 2
                - }
              - }
    
### 5. api/payment POST
    - Parameters:
        - amount: 200
        - iban: TN1946981212305359050634
    - Response:
        - {
            - "data": {
                - "user_id": 11,
                - "card_id": 11,
                - "price": "200",
                - "updated_at": "2022-08-14T20:50:32.000000Z",
                - "created_at": "2022-08-14T20:50:32.000000Z",
                - "id": 7
            - }
        - }
### 6. api/report/accounting  GET
    - Response:
        - {
            - "data": [
                - {
                    - "id": 1,
                    - "user_id": 1,
                    - "to_pay": "51692",
                    - "created_at": "2022-08-13T21:11:07.000000Z",
                    - "updated_at": "2022-08-14T20:31:33.000000Z",
                    - "deleted_at": null
                - },
                - {
                    - "id": 2,
                    - "user_id": 11,
                    - "to_pay": "51492",
                    - "created_at": "2022-08-14T20:50:15.000000Z",
                    - "updated_at": "2022-08-14T20:50:32.000000Z",
                    - "deleted_at": null
                - }
            - ]
        - }
### 7. api/report/orders    POST   ->  sends orders groupBy user_id
    - Parameters:
        - from: date_format:Y-m-d >  2022-08-14  > optional
        - to: date_format:Y-m-d  >  2022-08-16  > optional
    - Response:
        - {
            - "data": {
                - "1": [
                    - {
                        - "id": 1,
                        - "user_id": 1,
                        - "book_id": 1,
                        - "order_number": "CTKTA1LBQ7",
                        - "quantity": 2,
                        - "price": "25846",
                        - "book": "{\"id\": 1, \"price\": \"12923\", \"title\": \"Otho Hudson\", \"quantity\": 76, \"created_at\": \"2022-08-13T21:09:30.000000Z\", \"deleted_at\": null, \"updated_at\": \"2022-08-13T21:09:30.000000Z\", \"book_number\": \"ELHGTDTENY\"}",
                        - "created_at": "2022-08-13T21:11:07.000000Z",
                        - "updated_at": "2022-08-13T21:11:07.000000Z",
                        - "deleted_at": null
                    - }
                - ],
                - "11": [
                    - {
                        - "id": 3,
                        - "user_id": 11,
                        - "book_id": 1,
                        - "order_number": "MWZHLEFHHU",
                        - "quantity": 20,
                        - "price": "258460",
                        - "book": "{\"id\": 1, \"price\": \"12923\", \"title\": \"Otho Hudson\", \"quantity\": 54, \"created_at\": \"2022-08-13T21:09:30.000000Z\", \"deleted_at\": null, \"updated_at\": \"2022-08-14T20:31:33.000000Z\", \"book_number\": \"ELHGTDTENY\"}",
                        - "created_at": "2022-08-14T20:50:15.000000Z",
                        - "updated_at": "2022-08-14T20:50:15.000000Z",
                        - "deleted_at": null
                    - }
                - ]
            - }
        - }
        

### 9. api/report/payments  POST
    - Parameters:
        - from: date_format:Y-m-d >  2022-08-14  > optional
        - to: date_format:Y-m-d  >  2022-08-16  > optional
    -Response: 
        {
            - "data": {
                - "1": [
                    - {
                        - "id": 1,
                        - "user_id": 1,
                        - "card_id": 13,
                        - "price": "20",
                        - "created_at": "2022-08-13T21:19:22.000000Z",
                        - "updated_at": "2022-08-13T21:19:22.000000Z",
                        - "deleted_at": null
                    - },
                    - {
                        - "id": 4,
                        - "user_id": 1,
                        - "card_id": 13,
                        - "price": "20",
                        - "created_at": "2022-08-13T21:33:59.000000Z",
                        - "updated_at": "2022-08-13T21:33:59.000000Z",
                        - "deleted_at": null
                    - }
                - ],
                - "11": [
                    - {
                        - "id": 7,
                        - "user_id": 11,
                        - "card_id": 11,
                        - "price": "200",
                        - "created_at": "2022-08-14T20:50:32.000000Z",
                        - "updated_at": "2022-08-14T20:50:32.000000Z",
                        - "deleted_at": null
                    - }
                - ]
            - }
        - }
