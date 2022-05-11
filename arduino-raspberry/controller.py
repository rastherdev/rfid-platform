import serial
import requests
from pprint import pprint

url = 'http://rfid.itspa.ezyro.com/api/tickets/create'

def die(error):
    raise Exception(error)

def formatTag(tag):
    tag = tag[2:]
    size = len(tag)
    tag = tag[:size -5]
    return tag

ser = serial.Serial('/dev/ttyUSB0', 9600);

requestTag = {}
while True:
    tag = formatTag(str(ser.readline()))
    requestTag = {'tag': ''+tag+''}
    requests.post(url, data = requestTag)
    print(tag)
    
ser.close()