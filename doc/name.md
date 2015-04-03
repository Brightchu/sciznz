SciClubs Name Conventions
======
_2015-03-31_

Database tables
------
* admin: Admin account
* category: Define the fields for a category. (*interface*)
* config: Static data like category hierarchy.
* device: Actual device, one device per entry. Contain device speficic attribute and some override attribute. (*override*)
* supply: Supply account.
* model: Fill the fields attribute for this model which required by this category. (*implement*)
* order: Order data, focus on user and fee.
* usage: Usage data, focus on time and capacity.
* user: User account.

#####Name as there means, and always use singular form. I don't want to play with `s`.

Backend arch
------
* *controller* just like commander while *model* like solider.
* Do authentication, account verification, and any other bussiness logic in controller.
* Model only responsible for do one thing at a time, so NEVER call another model in a model.
* Avoid use similar meaning but different words, we are not doing TOEFL.
