<?php require('inc/head.php'); ?>
<body class="single single-post postid-0 single-format-standard">
    
    <?php require('inc/header.php'); ?>
    
    <main role="main">

        <article class="container clearfix">
            <div class="col-sm">
                <?php require('inc/_content-article--header.php'); ?>
            </div>
            <div class="col-lg content content-main">

                <p>Functional programming is the mustachioed hipster of programming paradigms. Originally relegated to the annals of computer science academia, functional programming has had a recent renaissance that is due largely to its utility in distributed systems (and probably also because “pure” functional languages like Haskell are difficult to grasp, which gives them a certain cache).</p>
        <p>Stricter functional programming languages are typically used when a system’s performance and integrity are both critical — i.e. your program needs to do exactly what you expect every time and needs to operate in an environment where its tasks can be shared across hundreds or thousands of networked computers. <a title="Clojure" href="http://clojure.org/">Clojure</a><sup class="print_only" id="note-1"><a href="#1" class="link-reset">1</a></sup>, for example, powers <a title="Akamai" href="http://www.akamai.com/">Akamai</a><sup class="print_only" id="note-2"><a href="#2">2</a></sup>, the massive content delivery network utilized by companies such as Facebook, while <a title="Twitter uses Scala" href="http://www.infoq.com/articles/twitter-java-use">Twitter famously adopted</a><sup class="print_only" id="note-3"><a href="#3">3</a></sup> <a href="http://www.scala-lang.org/">Scala</a><sup class="print_only" id="note-4"><a href="#4">4</a></sup> for its most performance-intensive components, and <a href="http://www.haskell.org/haskellwiki/Haskell">Haskell</a><sup class="print_only" id="note-5"><a href="#5">5</a></sup> is used by AT&amp;T for its network security systems.</p>
        <?php require('inc/_content-image--variations.php'); ?>
        <h2>
            <a name="content--headline" class="anchor link-reset" href="#content--headline" aria-hidden="true">Überschrift mit Anker</a>
        </h2>
        <p>First, data in functional programs should be <strong>immutable</strong>, which sounds serious but just means that it should never change. At first, this might seem odd (after all, who needs a program that never changes anything?), but in practice, you would simply create new data structures instead of modifying ones that already exist. For example, if you need to manipulate some data in an array, then you’d make a new array with the updated values, rather than revise the original array. Easy!</p>
        <p>Secondly, functional programs should be <strong>stateless</strong>, which basically means they should perform every task as if for the first time, with no knowledge of what may or may not have happened earlier in the program’s execution (you might say that a stateless program is <a href="http://programmers.stackexchange.com/a/154523">ignorant of the past</a><sup class="print_only" id="note-11"><a href="#11">11</a></sup>). Combined with immutability, this helps us think of each function as if it were operating in a vacuum, blissfully ignorant of anything else in the application besides other functions. In more concrete terms, this means that your functions will operate only on data passed in as arguments and will never rely on outside values to perform their calculations.</p>
        <p>Immutability and statelessness are core to functional programming and are important to understand, but don’t worry if they don’t quite make sense yet. You’ll be familiar with these principles by the end of the article, and I promise that the beauty, precision and power of functional programming will turn your applications into bright, shiny, data-chomping rainbows. For now, start with simple functions that return data (or other functions), and then combine those basic building blocks to perform more complex tasks.</p>
        <h3>
            <a name="content--code-beispiel" class="anchor link-reset" href="#content--code-beispiel" aria-hidden="true">Code Beispiel gleich mal über mehrere Zeilen weil es ja auch sein kann das eine Zeile nicht ausreicht und Mehrzeiligkeit unumgänglich ist</a>
        </h3>
        <p>For example, let’s say we have an API response:</p>
        <?php include('inc/_content-code.php'); ?>
        <p>If we want to use a chart or graphing library to compare the average temperature to population size, we’d need to write some JavaScript that makes a few changes to the data before it’s formatted correctly for our visualization. Our graphing library wants an array of x and y coordinates, like so:</p>
        <pre><code class="language-javascript">[
          [x, y],
          [x, y]
          …etc
        ]
        </code></pre>
        <p>Here, <code>x</code> is the average temperature, and <code>y</code> is the population size.</p>
        <p>Without functional programming (or without using what’s called an “imperative” style), our program might look like this:</p>
        <pre><code class="language-javascript">var coords = [],
            totalTemperature = 0,
            averageTemperature = 0;

        for (var i=0; i &lt; data.length; i++) {
          totalTemperature = 0;

          for (var j=0; j &lt; data[i].temperatures.length; j++) {
            totalTemperature += data[i].temperatures[j];
          }

          averageTemperature = totalTemperature / data[i].temperatures.length;

          coords.push([averageTemperature, data[i].population]);
        }
        </code></pre>
        <p>Even in a contrived example, this is already becoming difficult to follow. Let’s see if we can do better.</p>
        <p>When programming in a functional style, you’re always looking for simple, repeatable actions that can be abstracted out into a function. We can then build more complex features by calling these functions in sequence (also known as “composing” functions) — more on that in a second. In the meantime, let’s look at the steps we’d take in the process of transforming the initial API response to the structure required by our visualization library. At a basic level, we’ll perform the following actions on our data:</p>
        <ul>
        <li>add every number in a list,</li>
        <li>calculate an average,</li>
        <li>retrieve a single property from a list of objects.</li>
        </ul>
        <p>We’ll write a function for each of these three basic actions, then compose our program from those functions. Functional programming can be a little confusing at first, and you’ll probably be tempted to slip into old imperative habits. To avoid that, here are some simple ground rules to ensure that you’re following best practices:</p>
        <ol>
        <li>All of your functions must accept at least one argument.</li>
        <li>All of your functions must return data or another function.</li>
        <li>No loops!</li>
        </ol>
        <p>OK, let’s add every number in a list. Remembering the rules, let’s make sure that our function accepts an argument (the array of numbers to add) and returns some data.</p>
        <pre><code class="language-javascript">function totalForArray(arr) {
          // add everything
          return total;  
        }
        </code></pre>
        <p>So far so good. But how are we going to access every item in the list if we don’t loop over it? Say hello to your new friend, recursion! This is a bit tricky, but basically, when you use recursion, you create a function that calls itself unless a specific condition has been met — in which case, a value is returned. Just looking at an example is probably easiest:</p>
        <pre><code class="language-javascript">// Notice we're accepting two values, the list and the current total
        function totalForArray(currentTotal, arr) {

          currentTotal += arr[0]; 

          // Note to experienced JavaScript programmers, I'm not using Array.shift on 
          // purpose because we're treating arrays as if they are immutable.
          var remainingList = arr.slice(0,-1);

          // This function calls itself with the remainder of the list, and the 
          // current value of the currentTotal variable
          if(remainingList.length &gt; 0) {
            return totalForArray(currentTotal, remainingList); 
          }

          // Unless of course the list is empty, in which case we can just return
          // the currentTotal value.
          else {
            return currentTotal;
          }
        }
        </code></pre>
        <p><strong>A word of caution:</strong> Recursion will make your programs more readable, and it is essential to programming in a functional style. However, in some languages (including JavaScript), you’ll run into problems when your program makes a large number of recursive calls in a single operation (at the time of writing, “large” is about <a href="http://www.2ality.com/2014/04/call-stack-size.html">10,000 calls in Chrome, 50,000 in Firefox and 11,000 in Node.js</a><sup class="print_only" id="note-12"><a href="#12">12</a></sup>). The details are beyond the scope of this article, but the gist is that, at least <a href="https://people.mozilla.org/~jorendorff/es6-draft.html#sec-tail-position-calls">until ECMAScript 6 is released</a><sup class="print_only" id="note-13"><a href="#13">13</a></sup>, JavaScript doesn’t support something called “<a href="http://cs.stackexchange.com/a/7814">tail recursion</a><sup class="print_only" id="note-14"><a href="#14">14</a></sup>,” which is a more efficient form of recursion. This is an advanced topic and won’t come up very often, but it’s worth knowing.</p>
        <p>With that out of the way, remember that we needed to calculate the total temperature from an array of temperatures in order to then calculate the average. Now, instead of looping over each item in the <code>temperatures</code> array, we can simply write this:</p>
        <pre><code class="language-javascript">var totalTemp = totalForArray(0, temperatures);
        </code></pre>
        <p>If you’re purist, you might say that our <code>totalForArray</code> function could be broken down even further. For example, the task of adding two numbers together will probably come up in other parts of your application and subsequently should really be its own function.</p>
        <pre><code class="language-javascript">function addNumbers(a, b) {
          return a + b;
        }
        </code></pre>
        <p>Now, our <code>totalForArray</code> function looks like this:</p>
        <pre><code class="language-javascript">function totalForArray(arr, currentTotal) {
          currentTotal = addNumbers(currentTotal + arr[0]);

          var remainingArr = arr.slice(0,-1);

          if(remainingArr.length &gt; 0) {
            return totalForArray(currentTotal, remainingArr);
          }
          else {
            return currentTotal;
          }
        }
        </code></pre>
        <p>Excellent! Returning a single value from an array is fairly common in functional programming, so much so that it has a special name, “reduction,” which you’ll more commonly hear as a verb, like when you “reduce an array to a single value.” JavaScript has a special method just for performing this common task. Mozilla Developer Network provides a <a title="JavaScript reduce method" href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce">full explanation</a><sup class="print_only" id="note-15"><a href="#15">15</a></sup>, but for our purposes it’s as simple as this:</p>
        <pre><code class="language-javascript">// The reduce method takes a function as its first argument, and that function 
        // accepts both the current item in the list and the current total result from 
        // whatever calculation you're performing.
        var totalTemp = temperatures.reduce(function(previousValue, currentValue){
          // After this calculation is returned, the next currentValue will be 
          // previousValue + currentValue, and the next previousValue will be the 
          // next item in the array.
          return previousValue + currentValue;
        });
        </code></pre>
        <p>But, hey, since we’ve already defined an <code>addNumber</code> function, we can just use that instead.</p>
        <pre><code class="language-javascript">var totalTemp = temperatures.reduce(addNumbers);
        </code></pre>
        <p>In fact, because totalling up an array is so cool, let’s put that into its own function so that we can use it again without having to remember all of that confusing stuff about reduction and recursion.</p>
        <pre><code class="language-javascript">function totalForArray(arr) {
          return arr.reduce(addNumbers);
        }

        var totalTemp = totalForArray(temperatures);
        </code></pre>
        <p>Ah, now <em>that</em> is some readable code! Just so you know, methods such as <code>reduce</code> are common in most functional programming languages. These helper methods that perform actions on arrays in lieu of looping are often called &#8220;higher-order functions.&#8221;</p>
        <p>Moving right along, the second task we listed was calculating an average. This is pretty easy.</p>
        <pre><code class="language-javascript">function average(total, count) {
          return count / total;
        }
        </code></pre>
        <p>How might we go about getting the average for an entire array?</p>
        <pre><code class="language-javascript">function averageForArray(arr) {
          return average(totalForArray(arr), arr.length);
        }

        var averageTemp = averageForArray(temperatures);
        </code></pre>
        <p>Hopefully, you’re starting to see how to combine functions to perform more complex tasks. This is possible because we’re following the rules set out at the beginning of this article — namely, that our functions must always accept arguments and return data. Pretty awesome.</p>
        <p>Lastly, we wanted to retrieve a single property from an array of objects. Instead of showing you more examples of recursion, I’ll cut to the chase and clue you in on another built-in JavaScript method: <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map">map</a><sup class="print_only" id="note-16"><a href="#16">16</a></sup>. This method is for when you have an array with one structure and need to map it to another structure, like so:</p>
        <pre><code class="language-javascript">// The map method takes a single argument, the current item in the list. Check
        // out the link above for more complete examples.
        var allTemperatures = data.map(function(item) {
          return item.temperatures;
        });
        </code></pre>
        <p>That’s pretty cool, but pulling a single property from a collection of objects is something you’ll be doing all the time, so let’s make a function just for that.</p>
        <pre><code class="language-javascript">// Pass in the name of the property that you'd like to retrieve
        function getItem(propertyName) {
          // Return a function that retrieves that item, but don't execute the function.
          // We'll leave that up to the method that is taking action on items in our 
          // array.
          return function(item) {
            return item[propertyName];
          }
        }
        </code></pre>
        <p>Check it out: We’ve made a function that returns a function! Now we can pass it to the <code>map</code> method like this:</p>
        <pre><code class="language-javascript">var temperatures = data.map(getItem('temperature'));
        </code></pre>
        <p>In case you like details, the reason we can do this is because, in JavaScript, functions are “first-class objects,” which basically means that you can pass around functions just like any other value. While this is a feature of many programming languages, it’s a requirement of any language that can be used in a functional style. Incidentally, this is also the reason you can do stuff like <code>$('#my-element').on('click', function(e) … )</code>. The second argument in the <code>on</code> method is a <code>function</code>, and when you pass functions as arguments, you’re using them just like you would use values in imperative languages. Pretty neat.</p>
        <p>Finally, let’s wrap the call to <code>map</code> in its own function to make things a little more readable.</p>
        <pre><code class="language-javascript">function pluck(arr, propertyName) {
          return arr.map(getItem(propertyName));
        } 

        var allTemperatures = pluck(data, 'temperatures');
        </code></pre>
        <p>All right, now we have a toolkit of generic functions that we can use anywhere in our application, even in other projects. We can tally up the items in an array, get the average value of an array, and make new arrays by plucking properties from lists of objects. Last but not least, let’s return to our original problem:</p>
        <pre><code class="language-javascript">var data = [
          { 
            name: "Jamestown",
            population: 2047,
            temperatures: [-34, 67, 101, 87]
          },
          …
        ];
        </code></pre>

        <aside class="print-only">
            <h4>Footnotes</h4>
            <ol><li id="#1"><a href="#note-1">1 http://clojure.org/</a></li></ol>
        </aside>  
            </div>


        </article>
</main>
<?php require('inc/footer.php'); ?>
<?php require('inc/scripts.php'); ?>
</body>
</html>