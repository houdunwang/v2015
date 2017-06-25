<?php
$config = [
    //应用ID,您的APPID。
    'app_id'               => "2017062007525894",

    //商户私钥
    'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDLzZOGFKnQCLySlnS8J+Q5NbigU+373b9zs7pQBtVUDlBzVHHPNLFqi4zGJ32cjlJuKt/RMzEzo3FAy1MwZIXKTvdtwfyH4qh4QKo+cXhdxNp5zcxbED+JFFFTt+kPgcAIjTopG2FtzjqlDTq5+Aqh4ZfOSFlFeFRbVyzMrXg2JTFGUrAXpm4GI1CPDyeoWO0MPvtkTeC1ZXrC+ilKBz4YXHYDjVvFePJTZXGn9KBt1TjPBhSAEoD1cDNjEgA45JxBrmOXGFsZTBS8DGzaQCedlVnKPLBUM7tB3pxEtxiqUlquiO1m4jOZ+kW+LhUKNHiQHE4HXxa/mc4jLXLYXiODAgMBAAECggEAM9rbtVrelisS5+1WSGWSASh1EH4qaFJUmzjYp/IFJ3z45U9QIduTZLubFvQHVuUzfgp0pkLzOuNUNptFUGPTUtViyU95VI3MNcSmTHsMmDc1K5a8b1MkB1nfE4EQ0Lw/wy1D5h+sW4cEjuhdz+GXuvaubHMmG7HxLMhygqWEl6nMsk5SeWgFUNaJS347KiriC72oIvfGteactSNhd/gYPsTc1d5Lo8GsMhzON7h0n/fgqCo4H7SG/wqoYhMjOgJWZrh93KEl2GLUXn2iP/+XpjsMZQEAqbYzOEwL/Lh6LpPCu8s07/wH4RQCIsmFowWfQqjRxrk3N+GoBeNiZ6BI4QKBgQDkwQ4Nub8nkcqDcY5wAmrfveYHsGdkKxiSrzawM7jy2MM59rqu5pJaw3Dx012G0JkP7DUoTVcptnj2NemJqAGHPl1T1bu+LQEfSkjYkPbYMT2Z4eUaueg0RLff27RaxbjqfmVpG6kh99fcxUshj3BiQkJmGvOzDLinJYZU4u/qUQKBgQDkE7zFAX18kta/6Wtt0A5RvLRckJtPo7/mxq2eCOjzMIlKId51Q4fKy9wdYhzrxAHbeps/GhTRmGINzaC+dWm/EdtghaQd57EtpPLWcfEV+j+6oCY/RABwrJ/QvYC1hm3ZJLPBiATD/rXtX7DhcpRGkUcCGzK5lAIF6d9swxRnkwKBgF8NWSma5TMsAVpc9TLVzlLqNYs8YbndrnhFFhRhaZh/OZ/8RdYnOOk+DNBvY42BYBidrfjxKibLC7hC7qekh/4Ki/0p8rkzOiQmWd6jXe63h0FJ/Ej+tt4BL+Z1BJwzTIMjwj/Knpzev3OdB3sKf0hVAAItcNYVkyThEtBy+/4BAoGBAJHSILXgXwe/pjerGHlsNUuDF9m6xuHjMvVsf2J0FeQuWwifoOheVbqOHlxW92Cxv/JAcHOmzDq5b6+dkbFTxllYJGeQ6j4IfVpOhMggr2A60HYUoH+Ajbt8Uu2Vy23D1gWoFpmcylc5Sb3LmX560FxR1BF/rC3EeIqpXaTfEPOrAoGBAJSZoKg3wc7CLfDBPVUAEtQO68W6jgFADOMalAS6CJkZMagapIVBjqcoTe18Nj6ahY2hAQ2v/bVoD7r9Uy5+VJUEE9/d1UnWh6Ps7VcD1gNETfJb7y8vP4exuGPniTKBuGaQW6263Z3NrSqLjztQXSXTorQSgdYon8BrupycDvxQ",

    //异步通知地址
    'notify_url'           => "http://www.houdunwang.com/alip/notify_url.php",

    //同步跳转
    'return_url'           => "http://www.houdunwang.com/alip/return_url.php",

    //编码格式
    'charset'              => "UTF-8",

    //签名方式
    'sign_type'            => "RSA2",

    //支付宝网关
    'gatewayUrl'           => "https://openapi.alipay.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key'    => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAp/lpnWmf0z2nH/RsvdrLHbx9WLVnW9BOTb14oOyKZpEIX6e0GmZjUUvvRqatUkpwRkT8jW/Cy0UuhuEAy9sP4qL/fJd0ErUM0L8HdQpLjNOguC2Ald3/WYsfTK9miA+cR1O1BtALcrp0Vmqrx8GulbIW/7+C6pP/uthwYpyxg6uvXBC4JmsbzyE1Tp12xCDJnwHfnRjxmR8FtNZjy4Ax0oQgiwOwLmB0N5wPLH6kBni9GSHlRE0s+ZF0638Fr53eSDjqiX0DQOSfNi2lBIZjrseY9eu9njgbyjk10vmowSRUUFOFu4oA5ClRwDG6HktxDOE2OgWpI6CiCNpO02KHgwIDAQAB",
];