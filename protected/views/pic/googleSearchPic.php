<?php
echo CHtml::textField("searchValue", $item->title, array("size"=>'78', "id"=>"searchValue", 'onchange'=>"OnLoadDoSearch()"));
echo CHtml::button('search picture', array('onclick'=>'OnLoadDoSearch()'));
echo '<div id="content">Loading...</div>';
echo '<div class = "clearAllDiv" ></div>';
?>

<script
	src="https://www.google.com/jsapi?key=ABQIAAAAQS5DzpfgMa53w8AlWbnA6xT8urE7ypOvqky3AO9awdcYZJIxLRRuF87jMJtAx4i26jnyubWAWgpHeA"></script>
<script type="text/javascript">
      google.load('search', '1');

      var imageSearch;

      function addPaginationLinks() {
      
        // To paginate search results, use the cursor function.
        var cursor = imageSearch.cursor;
        var curPage = cursor.currentPageIndex; // check what page the app is on
        var pagesDiv = document.createElement('div');
        pagesDiv.id = "pagesNumberDiv";

        var label = document.createTextNode('Pages :');
        var pageOneDiv = document.createElement('div');
        pageOneDiv.appendChild(label);
        pageOneDiv.setAttribute("class", "googleLinkPageTitle");
        pagesDiv.appendChild(pageOneDiv);

        for (var i = 0; i < cursor.pages.length; i++) {
          var page = cursor.pages[i];
		  var pager;
          if (curPage == i) { 

          // If we are on the current page, then don't make a link.
            var label = document.createTextNode(' ' + page.label + ' ');
            //label.setAttribute('class', 'googleLinkPageNumber');
            //pagesDiv.appendChild(label);
            pager = label;
          } else {

            // Create links to other pages using gotoPage() on the searcher.
            var link = document.createElement('a');
            link.href = 'javascript:imageSearch.gotoPage('+i+');';
            link.innerHTML = page.label;
            //link.style.marginRight = '2px';
            //pagesDiv.appendChild(link);
            pager = link;
          }
          
          //pager.setAttribute('class','googleLinkPageNumber');
          
          var pageOneDiv = document.createElement('div');
          pageOneDiv.appendChild(pager);
          pageOneDiv.setAttribute("class", "googleLinkPageNumber");
          pagesDiv.appendChild(pageOneDiv);
          
        }

        var contentDiv = document.getElementById('content');
        var cleanDiv = document.createElement('div');
        cleanDiv.setAttribute("class", "clearAllDiv");
        pagesDiv.appendChild(cleanDiv);
        contentDiv.appendChild(pagesDiv);
      }

      function searchComplete() {

        // Check that we got results
        if (imageSearch.results && imageSearch.results.length > 0) {

          // Grab our content div, clear it.
          var contentDiv = document.getElementById('content');
          contentDiv.innerHTML = '';

          // Loop through our results, printing them to the page.
          var results = imageSearch.results;

          addPaginationLinks(imageSearch);
          
          for (var i = 0; i < results.length; i++) {
            // For each result write it's title and image to the screen
            var result = results[i];
            var imgContainer = document.createElement('div');
 			imgContainer.id = "googleImgDiv";
            var addLink = document.createElement('a');
            
            var newImg = document.createElement('img');
            newImg.id = "googleImage";

		    addLink.setAttribute("href", window.location.href+"?imgUrl="+encodeURIComponent(result.url) );
		    addLink.innerHTML = "<br>size: " + result.height + "*" + result.width + " add pic.";

            // There is also a result.url property which has the escaped version
            newImg.src = result.tbUrl;
	        //title.appendChild(addLink);
	    
	    	imgContainer.appendChild(addLink);
	    	addLink.appendChild(newImg);
            //imgContainer.appendChild(newImg);

            // Put our title + image in the content
            contentDiv.appendChild(imgContainer);
          }

          // Now add links to additional pages of search results.
          

          
        }
      }

      function OnLoadDoSearch() {
      
        // Create an Image Search instance.
        imageSearch = new google.search.ImageSearch();

        // set result size
        imageSearch.setResultSetSize(8);
        // Set searchComplete as the callback function when a search is 
        // complete.  The imageSearch object will have results in it.
        imageSearch.setSearchCompleteCallback(this, searchComplete, null);

        // Find me a beautiful car.
        var searchValue = document.getElementById('searchValue').value;
        imageSearch.execute(searchValue);
        
        // Include the required Google branding
        google.search.Search.getBranding('branding');
        return false;
      }
      
      google.setOnLoadCallback(OnLoadDoSearch);
</script>
