import tweepy

import random

# main-Function
def main():
 
    # 1. Twitter-API-Config
    consumer_key = 'robotama_puru'
    consumer_secret = 'XXXXXXXXXXXXXXXXXXX'
    access_token_key = '1571322027881156608-aVxlsUlPxw3OTAWS9Lqwh2dBGd5Lk3'
    access_token_secret = 'XFDGji3ny19Db82NZtT90cv3QEmlt3PyVoJO6E7iXB0Me'
 
    auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
    auth.set_access_token(access_token_key, access_token_secret)
    api = tweepy.API(auth)
 
    # ～ここより下にTwitter上で実行したい処理を書く～

    # ツイート => update_status(ツイート内容)
    api.update_status('ロボ玉')




 
if __name__ == "__main__":
    main()





# < Access Token と Access Token Secret >

# consumer_key: robotama_puru

# consumer_secret: 


# Access Token: 1571322027881156608-aVxlsUlPxw3OTAWS9Lqwh2dBGd5Lk3

# Access Token Secret: XFDGji3ny19Db82NZtT90cv3QEmlt3PyVoJO6E7iXB0Me


# APP ID: 25492635



# API キーとシークレット
# https://developer.twitter.com/en/docs/authentication/oauth-1-0a/api-key-and-secret










