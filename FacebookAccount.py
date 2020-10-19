#!/usr/bin/env python
# -*- coding: utf-8 -*- 

from bs4 import BeautifulSoup
import requests
import re 

FACEBOOK_UID = "" 	# Facebook User ID
FACEBOOK_XS  = "" 	# Get Your Facebook XS from your cookies

class FacebookAccount(object):
	"""Facebook Auto Birthday Sender
	   We all have a lot of Facebook friends and sometimes we do not have time to send 'Happy Birthday' wishes to them.
	   This script was made for that purpose. Auto-Pilot your happy-birthday-wishes to your Facebook friends
	"""
	MAIN_URL 		= "https://mbasic.facebook.com/home.php?sk=h_chr"
	BIRTHDAY_URL    = "https://mbasic.facebook.com/browse/birthdays/"
	DEFAULT_USER_AGENT 	= 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0'

	def __init__(self, fb_xs, fb_cuser):
		self.fb_xs = fb_xs
		self.fb_cuser = fb_cuser

	def getBirthdays(self):
		headers = { 'User-Agent' : self.DEFAULT_USER_AGENT, 'Referer' : self.BIRTHDAY_URL }
		cookies = { 'xs': self.fb_xs, 'c_user': self.fb_cuser}
		response = requests.get(self.BIRTHDAY_URL, cookies=cookies, headers=headers)
		return response.text

	def getUserID(self, userProfile):
		headers = { 'User-Agent' : self.DEFAULT_USER_AGENT, 'Referer' : "https://mbasic.facebook.com/" + str(userProfile) }
		cookies = { 'xs': self.fb_xs, 'c_user': self.fb_cuser}
		response = requests.get("https://mbasic.facebook.com/" + str(userProfile), cookies=cookies, headers=headers)
		matches = re.findall(r"\<a href=\"\/messages\/thread\/([0-9]{1,20})", response.text)
		if matches:
			return "".join(matches)
		else:
			return -1

	def sendMessage(self, userID, message="Happy Birthday 😊"):
		headers = { 'User-Agent' : self.DEFAULT_USER_AGENT, 'Referer' : 'https://m.facebook.com/messages/read/?fbid='+str(userID) }
		cookies = { 'xs': self.fb_xs, 'c_user': self.fb_cuser}
		firstRes = requests.get('https://mbasic.facebook.com/messages/compose/?ids='+str(userID), cookies=cookies, headers=headers)
		firstResParser = BeautifulSoup(firstRes.text, "html.parser")
		formObject = firstResParser.find("form", attrs={'id': 'composer_form'})
		allInputs = formObject.find_all('input', attrs={'type': 'hidden'})
		post_fields = {}
		for singleInput in allInputs:
			if singleInput:
				post_fields[singleInput.get('name')] = singleInput.get('value')
		post_fields['body'] = message
		post_fields['send'] = 'Send'
		finalRes = requests.post("https://mbasic.facebook.com/messages/send/?icm=1&amp;refid=12", data=post_fields, cookies=cookies, headers=headers)

		if finalRes.status_code == 200:
			return True
		else:
			return False

	def sendBirthdays(self):
		successFlag = 0
		content = self.getBirthdays()
		contentParser = BeautifulSoup(content, "html.parser")
		bdDiv = contentParser.find("div", attrs={'id': 'objects_container'})
		bdPeople = bdDiv.find_all("h3")
		for bdPerson in bdPeople:
			myFriendUsername = bdPerson.find("a").get('href')
			self.sendMessage(self.getUserID(myFriendUsername))
			successFlag += 1
		return successFlag


myAccount = FacebookAccount(FACEBOOK_XS, FACEBOOK_UID)
print(myAccount.sendBirthdays())
