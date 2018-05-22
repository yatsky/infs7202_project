#!/usr/bin/env python
import urllib.request as request
import requests
import os

def is_ascii_only(text):
    try:
        text.encode("ascii")
    except UnicodeEncodeError:
        return False
    return True

def delete_photos():
    for file in os.listdir(save_path):
        file_path = os.path.join(save_path, file)
        try:
            if os.path.isfile(file_path):
                os.unlink(file_path)
        except Exception as e:
            continue

api    = 'https://www.nasa.gov/api/1/'
public = 'https://www.nasa.gov/sites/default/files'
save_path = './images/nasa/'


with requests.session() as s:
    s.headers['user-agent'] = 'Mozilla/5.0'

    # first page
    for page in range(1):
        r = s.get(api + 'query/ubernodes.json',
                params={'page': page, 'unType[]': 'image'})
        for ubernode in r.json()['ubernodes']:
            nid = ubernode['nid']
            r = s.get(api + 'record/node/{}.json'.format(nid))
            title = r.json()['ubernode']['title']
            if is_ascii_only(title):
                uri = r.json()['images'][0]['uri'].replace('public:/', public, 1)
                request.urlretrieve(uri, "{}{}.jpg".format(save_path, title))
            else:
                continue
