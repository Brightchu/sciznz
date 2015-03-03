Style Guide
===

1. Don't repeat yourself
---
1. Repeated, copy-paste code is strictly prohibited in this project

2. Security is king, performance is queen, while elegant is god
---
1. For things play with data source, like `Model` in this project, dont'be to lazy to hand write every single SQL statement. It will keep your clear about what's happening in database, also good for security and performance
2. High performance system is build from high performance architecture, not tricky code
3. For other cases, write as short code as possible because it means elegant

3. Explicit over implicit
---
1. Don't rely on overloading or magic method to create bunch of functions
2. If the module/class/function your are writing will be used by other module, or even other guys, make sure you have explicitly declare it, and then your are free to delegate the logic
