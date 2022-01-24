# php-jwt
Api test:
Database name=php_auth_api
Testing on postman
Cms test:
Database name=manage
Email: moustafa@moustafa.com
Password: 12345678
First query:
All product had been promoted
Second query:
All product and categories and sub categories for an organization
Third query:
All brands and vendors for an organization
Fourth query:
SELECT products.name AS product_name, promotions.name as promotion_name, count(sales.promotion_product_id)
                    FROM sales
                    INNER JOIN promotions_products ON (sales.promotion_product_id = promotions_products.id)
                    INNER JOIN products ON (promotions_products.product_id = products.id)
                    INNER JOIN promotions ON ( promotions_products.promotion_id = promotions.id)
                    WHERE sales.id = {$r[‘id’]}
In case we have different user role I prefer to separate in different project or different folders
