# TestesShopeeAPI

Para que a integração possa efetivamente funcionar, existem alguns requisitos que devem ser cumpridos:

1. Cadastro de uma conta de desenvolvedor, podendo ser de 3 tipos diferentes:  Vendedor CPF; Vendedor CNPJ ou Third-party Partner Platform;
2. A criaçao de um app na Open Platform da Shopee que neste exemplo seria um Product Management, que é um tipo de app usado para gerir processos relacionados a produtos.
    1. Os dois processos acima necessitam da revisão e aprovação da shopee.
    2. É recomendado que seja usado um IP estático.

1. Rotina de Autenticação: existem 3 tipos diferentes de OpenAPI por conta dos diferentes parâmetros comuns. O importante neste caso é a Shop API, que apresenta os seguintes parâmetros:
    
    Shop API: **partner_id, api_path, timestamp, access_token, shop_id**
    
    Exemplo：
    
    partner_id: `2001887`
    
    api_path: `/api/v2/shop/get_shop_info`
    
    timestamp: `1655714431`
    
    access_token: `59777174636562737266615546704c6d`
    
    shop id: `14701711`
    

Seguindo, é necessário criar um ****Cálculo de Assinatura**** em que precisamos concatatenar o API path com os parâmetros apresentados para gerar uma Basestring. Exemplo：

Basestring = `2001887/api/v2/shop/get_shop_info165571443159777174636562737266615546704c6d14701711`

O próximo passo é **calcular a assinatura usando o algoritmo HMAC-SHA256** na base string e na partner key, o resultado do cálculo é uma string codificada em hexadecimal. Exemplo：

sign=`56f31d01aeda9d08bf456b37f6f6640ef8614b4d6ad49baafe30b39a061f0e26`

Agora toda vez que for necessário fazer uma requisição usaremos um método que gera esta assinatura para efetivamente nos autenticarmos na API. 



**Criação do Produto:** Para a criação de um produto é necessário a utilização de diversos métodos antes de efetivamente cadastrar um produto, e são eles: 
    1. **v2.media_space.upload_image -** Fazemos o upload da imagem do produto para o servidor da shopee
    2. **v2.product.category_recommend -** Fornecemos o nome do produto e a imagem para que a API forneça a recomendação de uma categoria para  seu produto.
    3. **v2.product.get_attributes -** Retorna a lista de atributos que uma certa categoria de produto deve ter
    4. **v2.product.get_brand_list -** Retorna uma lista de marcas
    5. **v2.product.get_dts_limit -** Retorna o dia para o limite de envio
    6. **v2.product.add_item -** Ai então com os resultados dos métodos acima conseguimos adicionar um produto, claro que é necessário passar mais parâmetros do que os apenas obtidos acima.
    
    Abaixo temos um exemplo de corpo da mensagem que seria usado numa requisição do método add_item:
    
    ```php
    {
        "description":"Sensor de Nível Pá Rotativa",
        "item_name":"Sensor de Nível Pá Rotativa",
        "category_id":14695,
        "brand":{
            "brand_id":123,
            "original_brand_name":"Brasiltec"
        },
        "logistic_info":[
            {
                "sizeid":0,
                "shipping_fee":23.12,
                "enabled":true,
                "is_free":false,
                "logistic_id":80101
            },
            {
                "shipping_fee":20000,
                "enabled":true,
                "is_free":false,
                "logistic_id":80106
            },
            {
                "is_free":false,
                "enabled":false,
                "logistic_id":86668
            },
            {
                "enabled":true,
                "price":12000,
                "is_free":true,
                "logistic_id":88001
            },
            {
                "enabled":false,
                "price":2,
                "is_free":false,
                "logistic_id":88014
            }
        ],
        "weight":1.1,
        "item_status":"UNLIST",
        "image":{
            "image_id_list":[
                "a17bb867ecfe900e92e460c57b892590",
                "30aa47695d1afb99e296956699f67be6",
                "2ffd521a59da66f9489fa41b5824bb62"
            ]
        },
        "dimension":{
            "package_height":11,
            "package_length":11,
            "package_width":11
        },
        "attribute_list":[
            {
                "attribute_id":4811,
                "attribute_value_list":[
                    {
                        "value_id":0,
                        "original_value_name":"",
                        "value_unit":""
                    }
                ]
            }
        ],
        "original_price":123.3,
        "seller_stock": [
            {
                "stock": 0
            }
        ],
        "tax_info":{
            "ncm":"123",
            "same_state_cfop":"123",
            "diff_state_cfop":"123",
            "csosn":"123",
            "origin":"1",
            "cest":"12345",
            "measure_unit":"1"
        },
        "complaint_policy":{
            "warranty_time":"ONE_YEAR",
            "exclude_entrepreneur_warranty":"123",
            "diff_state_cfop":true,
            "complaint_address_id":123456,
            "additional_information":""
        },
        "description_type":"extended",
        "description_info":{
            "extended_description":{
                "field_list":[
                    {
                        "field_type":"text",
                        "text":"text description 1"
                    },
                    {
                        "field_type":"image",
                        "image_info":{
                            "image_id":"1e076dff0699d8e778c06dd6c02df1fe"
                        }
                    },
                    {
                        "field_type":"image",
                        "image_info":{
                            "image_id":"c07ac95ba7bb624d731e37fe2f0349de"
                        }
                    },
                    {
                        "field_type":"text",
                        "text":"text description 1"
                    }
                ]
            }
        }
    }
    ```
    

Para mais informações, acesse a documentação oficial da Shopee sobre a API: [Shopee Open Platform](https://open.shopee.com/)
