<section id="modalStarter">
    <div class="modal fade" id="createCampaignModal" data-dismiss="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title ">Create Pitch</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card h-100">
                                    <div class="card-header">Press Pitch Builder</div>
                                    <div class="card-body">
                                        <p class="card-text mb-1">Press pitch builder will build a pitch for you by
                                            asking 7 simple questions about
                                            your business. </p>
                                    </div>
                                    <div class="card-footer footerTweak text-muted">
                                        <div class="float-right">
                                            <a class="typeform-share button nav-link text-white"
                                                href="https://hooty.typeform.com/to/WMpn5C?name={{auth()->guard('web')->user()->first_name}}&userid={{auth()->guard('web')->user()->id}}"
                                                data-mode="popup" data-dismiss="modal"
                                                style="display:inline-block;text-decoration:none;background-color:#0294FF;color:white;cursor:pointer;font-family:Source Sans Pro,Helvetica,Arial,sans-serif;font-size:0.85rem;line-height:35px;text-align:center;margin:0;height:35px;padding:0px 20px;border-radius: 0.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;"
                                                data-submit-close-delay="5" target="_blank">GET STARTED</a>
                                            <script>
                                                (function() { var qs,js,q,s,d=document, gi=d.getElementById, ce=d.createElement, gt=d.getElementsByTagName, id="typef_orm_share", b="https://embed.typeform.com/"; if(!gi.call(d,id)){  js=ce.call(d,"script"); js.id=id; js.src=b+"embed.js"; q=gt.call(d,"script")[0]; q.parentNode.insertBefore(js,q) } })()
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" style="opacity:0.9">
                                <div class="card h-100">
                                    <div class="card-header">Compose Pitch</div>
                                    <div class="card-body">
                                        <p class="card-text mb-1"> If you are already a pro in writing press pitches,
                                            use this option to take you directly
                                            to compose page. </p>
                                    </div>
                                    <div class="card-footer footerTweak text-muted">
                                        <div class="float-right">
                                            <a class="button nav-link text-white" href="/message/create"
                                                style="display:inline-block;text-decoration:none;background-color:#0294FF;color:white;cursor:pointer;font-family:Source Sans Pro,Helvetica,Arial,sans-serif;font-size:0.85rem;line-height:35px;text-align:center;margin:0;height:35px;padding:0px 20px;border-radius: 0.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;">GET
                                                STARTED</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" style="opacity:0.9">
                                <div class="card h-100">
                                    <div class="card-header">Video Pitch</div>
                                    <div class="card-body">
                                        <p class="card-text mb-1"> Impress journalists with a video pitch, you can
                                            upload or record videos combine them,
                                            add effects </p>
                                    </div>
                                    <div class="card-footer footerTweak text-muted">
                                        <div class="float-right">
                                            <a class="button nav-link text-white" href data-dismiss="modal"
                                                data-toggle="modal" data-target="#videoComposer"
                                                style="display:inline-block;text-decoration:none;background-color:#0294FF;color:white;cursor:pointer;font-family:Source Sans Pro,Helvetica,Arial,sans-serif;font-size:0.85rem;line-height:35px;text-align:center;margin:0;height:35px;padding:0px 20px;border-radius: 0.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;">GET
                                                STARTED</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('.typeform-share').click(function(){
        $('#createCampaignModal').modal('hide');
    })
    
window.__lo_site_id = 158749;

(function() {
var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
 })();


</script>