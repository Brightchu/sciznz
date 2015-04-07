Database Schema
===
_2015-04-07_

Goal
---
##### Maximum flexibility!

Table
---
##### Name as there means, and always use singular form. I don't want to play with `s`.

* **admin**: Admin account
* **category**: Define the fields for a category. (*interface*)
* **config**: Static data like category hierarchy.
* **device**: Actual device, one device per entry. Contain device speficic attribute and some override attribute. (*override*)
* **group**: User group.
* **helper**: Helper account.
* **member**: Membership relation between user and group.
* **model**: Fill the attributes defined by category. (*implement*)
* **order**: An intent to use an device.
* **pay**: Payment detail.
* **supply**: Supply account.
* **usage**: Resource unit usage.
* **user**: User account.

JSON
---
##### Standardize json format
**catgory.field**: list of attribute key
```
[key1, key2]
```

**model.field**: key, value pair
```
{"key1":"value1", "key2": "value2"}
```

**device.field**: key, value pair
```
{"key1":"value1", "key2": "value2"}
```

**device.schedule**: mixed
```
{
	"method": ['RESOURCE', 'UNLIMITED'],
	"workday": [1, 2, 3, 4, 5],
	"resource": {
		"8点-11点": 3,
		"13点-16点": 2,
		"18点-20点": 3
	}
}
```
