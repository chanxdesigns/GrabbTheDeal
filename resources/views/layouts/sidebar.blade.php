{{-----------------------------------------
    Left-Sidebar Template
    Renders Left-Sidebar
    -- Template Partial --
-----------------------------------------}}

    <div class="sidebar-wrapper pull-left">
        @yield('sidebar')
        {{-- Social Share Buttons --}}
        <p class="card-header">Share The Love</p>
        <div class="card-wrapper">
            <div class="sidebar-gen">
                <div class="sidebar-share">
                    <ul class="share-buttons">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><img src="//cdn.grabbthedeal.in/assets/img/share/Facebook.png"></a></li>
                        <li><a href="https://twitter.com/intent/tweet?source={{Request::fullUrl()}}&via=grabbthedeal" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL)); return false;"><img src="//cdn.grabbthedeal.in/assets/img/share/Twitter.png"></a></li>
                        <li><a href="https://plus.google.com/share?url={{Request::fullUrl()}}" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><img src="//cdn.grabbthedeal.in/assets/img/share/Google.png"></a></li>
                        <li><a href="mailto:?subject=&body=: {{Request::fullUrl()}}" target="_blank" title="Email" onclick="window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&body=' +  encodeURIComponent(document.URL)); return false;"><img src="//cdn.grabbthedeal.in/assets/img/share/Email.png"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>