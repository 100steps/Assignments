# Regex Analysis
```js
// Match 2~5 Chinese characters, may specific to a Chinese name.
/[\u4e00-\u9fa5]{2,5}/

// Match numbers begin with 013/13/015/15/018/18, maybe trying to match a cell phone number.
/0?(13|15|18)[0-9]{9}/

// Maybe trying to match Chinese id-card number. 
\d{17}[\d|x]|\d{15}

// Match any number values between 10^6 and 10^13-1
[1-9]([0-9]{5,11})

// Match 6 digits, Ummm...
\d{6}

// Ha! It look like matching an IP address.
(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)\.(25[0-5]|2[0-4]\d|[0-1]\d{2}|[1-9]?\d)

// Match any English and Chinese characters besides "_-", often used to validate a nick name.
[A-Za-z0-9_\-\u4e00-\u9fa5]+


<(\S*?)[^>]*>.*?</>|<.*? />
/**
Maybe tring to match html/xml tag but is there any error in the exp?
Tested in chrome's console:

> "<html>hey</html>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<html>hey</html >".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<html s>hey</htm l>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<a></>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- ["<a></>", ""]
> "<ab></>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- ["<ab></>", ""]
> "<ab></a>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<ab></ab>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<ab><ab />".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- ["<ab><ab />", undefined]
> "<ab />".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- ["<ab />", undefined]
> "<html>abc</html>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- null
> "<html>abc</>".match(/<(\S*?)[^>]*>.*?<\/>|<.*? \/>/)
<- ["<html>abc</>", ""]

*/

// Match a physical mac-address (FF-FF-FF-FF-FF-FF)
[0-9a-fA-F]{2}([:|-][0-9a-fA-F]{2}){5}

// Match a string that does not contain space and begin with an English alpha. Most used in user's username
^[a-zA-Z]\w{5,17}$

// Match a string whose length between 8 to 10, and contains both number,lower case alpha and upper case alpha, Mose used to validate a password 
^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,10}$

// Match a telephone number, but... is there any error with the exp (the parenthese do not match)
(\d{3,4}-)|\d{3.4}-)?\d{7,8}$ 
```