# cheat-admin
 A simple control panel for users of several cheats.

# Features
 * Support for multiple cheats and generating keys for them.
 * A system for logging user actions linked to a specific key.
 * Getting certain files using a request.
 * Getting all the responses from the API in a convenient JSON format.

# TODO:
- [ ] File encryption using RSA-4048.
- [ ] Online purchase and sale of subscriptions directly on the website.

# INSTALLATION
 * Upload files to your FTP server.
 * Import the database (DATABASE.sql) into PhpMyAdmin.
 * Open the Controllers folder, go to the file globals.php and replace the username/password/database name on lines 4-6, respectively.

# API Requests - AUTH
 #### Important - send all requests to "sitename.com/api/api.php" in the POST format.
 
 Name | Type | Desc
----- | -----|--------
type* | string | This field is used to define the action. AUTH/LOG/FILE
key*  | string | The user's activation key. It is used to identify a person.
hwid* | string | This field is used to bind the key to a specific PC.

*always requered

## Responses

Wrong Activation Key
```js
{
  "Status":"WrongKey"
}
```

Activation Key Succsesfully Activated
```js
{
"Status":"Activated",
"HWID":"hwid",
"License":"key",
"LicenseTime":"30",
"SubEndTime":"512289476126",
"SubEndTimeHuman":"d/m/Y H:i:s",
"CheatID":"1"
}
```

Activation Key Banned
```js
{
"Status":"Banned",
"HWID":"hwid",
"License":"key",
"LicenseTime":"30",
"SubEndTime":"512289476126",
"SubEndTimeHuman":"d/m/Y H:i:s",
"CheatID":"1"
}
```

Activation Key Subscription Ended
```js
{
"Status":"SubEnded",
"HWID":"hwid",
"License":"key",
"LicenseTime":"30",
"SubEndTime":"512289476126",
"SubEndTimeHuman":"d/m/Y H:i:s",
"CheatID":"1"
}
```

Wrong HWID
```js
{
"Status":"WrongHWID",
"License":"key",
"CheatID":"1"
}
```

Succsesfull Auth
```js
{
"Status":"Authorized",
"HWID":"hwid",
"License":"key",
"LicenseTime":"30",
"SubEndTime":"512289476126",
"SubEndTimeHuman":"d/m/Y H:i:s",
"CheatID":"1"
}
```

# C++ Examples

C++ Auth example by Keaton

```cpp
auto c_api::auth(const char* key) -> bool {
	CURL* curl;
	CURLcode res;
	curl = curl_easy_init();
	json all;
 
	std::string post_fields = "type=auth&key=" + std::string(key) + "&hwid=" + YOUR_HWID_GENERATION_METHOD;

	if (curl) {
		std::string response;
		curl_easy_setopt(curl, CURLOPT_URL, this->site_link.c_str());
		curl_easy_setopt(curl, CURLOPT_POSTFIELDS, post_fields.c_str());
		curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, writer);
		curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response);

		res = curl_easy_perform(curl);
		if (res == CURLE_OK) {
			all = json::parse(response);

			auto link = all["Status"].get<std::string>();

			if (strstr(link.c_str(), "Authorized") or strstr(link.c_str(), "Activated")) {
				sprintf(error, "Auth");
				return true;
			}
			else if (strstr(link.c_str(), "WrongKey")) {
				sprintf(error, "Key not found");
				return false;
			}
			else if (strstr(link.c_str(), "Banned")) {
				sprintf(error, "Key banned");
				return false;
			}
			else if (strstr(link.c_str(), "WrongHWID")) {
				sprintf(error, "Incorrect HWID");
				return false;
			}
			else if (strstr(link.c_str(), "SubEnded")) {
				sprintf(error, "Subscription expired");
				return false;
			}
			else {
				sprintf(error, "Unknown error");
				return false;
			}
		}
	}
	return false;
}
```
