@extends('layout.app')

@section('content')
    <section>
        <div class="gap2 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row merged20" id="page-contents">
                            <div class="col-lg-3">
                                <aside class="sidebar static left">
                                  
                                    <div class="widget">
                                        <h4 class="widget-title">Raccourcis</h4>
                                        <ul class="naves">
                                            <li>
                                                <i class="ti-clipboard"></i>
                                                <a href="newsfeed.html" title="">Actualites</a>
                                            </li>
                                            <li>
                                                <i class="ti-mouse-alt"></i>
                                                <a href="inbox.html" title="">Problemes Inscriptions</a>
                                            </li>
                                            <li>
                                                <i class="ti-files"></i>
                                                <a href="fav-page.html" title="">Problemes Certifications</a>
                                            </li>
                                            <li>
                                                <i class="ti-user"></i>
                                                <a href="timeline-friends.html" title="">Problemes Releves de
                                                    notes</a>
                                            </li>
                                            <li>
                                                <i class="ti-image"></i>
                                                <a href="timeline-photos.html" title="">Problemes PVRs</a>
                                            </li>
                                            <li>
                                                <i class="ti-video-camera"></i>
                                                <a href="timeline-videos.html" title="">Problemes de Rattrapages</a>
                                            </li>
                                            <li>
                                                <i class="ti-comments-smiley"></i>
                                                <a href="messages.html" title="">Forum</a>
                                            </li>

                                            <!-- <li>
                <i class="ti-power-off"></i>
                <a href="landing.html" title="">Logout</a>
               </li> -->
                                        </ul>
                                    </div><!-- Shortcuts -->
                                    <div class="widget stick-widget">
                                        <h4 class="widget-title">Activités Recentes</h4>
                                        <ul class="activitiez">
                                            <li>
                                                <div class="activity-meta">
                                                    <i>Il y'a 10 ans</i>
                                                    <span><a href="#" title="">Vous avez commenté sur une vidéo
                                                            postée</a></span>
                                                    <h6>par <a href="time-line.html"> diamond.</a></h6>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="activity-meta">
                                                    <i>Il y'a 10 ans</i>
                                                    <span><a href="#" title="">Vous avez commenté sur une vidéo
                                                            postée</a></span>
                                                </div>
                                            </li>

                                        </ul>
                                    </div><!-- recent activites -->
                                    <!-- who's following -->
                                </aside>
                            </div><!-- sidebar -->
				
                            <div class="col-lg-6">
                            @if (Auth::user())
                                <div class="central-meta postbox">
                                    <span class="create-post">Creer un post (reserve aux autorises)</span>
                                    <div class="new-postbox">
                                        <figure>
                                            <img src="assets/images/resources/admin.jpg" alt="" class="pp">
                                        </figure>
                                        <div class="newpst-input">
                                            <form method="post" id="postForm" enctype="multipart/form-data" action="{{ route('post.store') }}">
												@csrf
												<input type="text" name="title" id="" placeholder="Titre">
                                                <textarea rows="2" placeholder="Rediger votre post" name="body"></textarea>
                                        </div>
                                        <div class="attachments">
                                            <ul>
												<li>
                                                    <i class="fa fa-file"></i>
                                                    <label class="fileContainer">
                                                        <input type="file" name="media[]" accept="image/*,video/*" multiple>
                                                    </label>
                                                </li>
                                               
                                                <li class="preview-btn">
                                                    <button class="post-btn-preview" type="submit"
                                                        data-ripple="">Previsualise</button>
                                                </li>
                                            </ul>
                                            <button class="post-btn" type="submit" data-ripple="">Poster</button>
                                            </form>

                                        </div>
                                        
                                    </div>
                                </div>
                                @endif
                                <div class="loadMore">
									@forelse ($posts as $post)
										<div class="central-meta item">
										<div class="user-post">
											<div class="friend-info">
												<figure>
													<img src="assets/images/resources/admin.jpg" alt="">
												</figure>
												<div class="friend-name">
													<div class="more">
														<div class="more-post-optns"><i class="ti-more-alt"></i>
															<ul>
																<li><i class="fa fa-pencil-square-o"></i>Modifier le post</li>
																<li><i class="fa fa-trash-o"></i>Supprimer le post</li>
																<li class="bad-report"><i class="fa fa-flag"></i>Signaler le post</li>
																
															</ul>
														</div>
													</div>
													<ins><a href="time-line.html" title="">{{ $post->user->name }}</a> {{ $post->title }}</ins>
													<span><i class="fa fa-globe"></i> publie le: {{ $post->created_at->format('d M Y H:i') }} </span>
												</div>
												<div class="post-meta">
													<p>
														{{ $post->body }}
													</p>
													<figure>
														<div class="img-bunch">
															<div class="row">
																{{-- <div class="col-lg-6 col-md-6 col-sm-6"> --}}
																		@foreach ($post->media as $media)
																			<figure>
																				<a href="#" title="" data-toggle="modal" data-target="#img-comt">
																					<img src="{{ $media->media_url }}" alt="">
																				</a>
																			</figure>
																		@endforeach
																	
																	
																{{-- </div> --}}
																
															</div>
														</div>	
														<ul class="like-dislike">
															<li><a class="bg-purple" href="#" title="Save to Pin Post"><i class="fa fa-thumb-tack"></i></a></li>
															<li><a class="bg-blue" href="#" title="Like Post"><i class="ti-thumb-up"></i></a></li>
															<li><a class="bg-red" href="#" title="dislike Post"><i class="ti-thumb-down"></i></a></li>
														</ul>
													</figure>	
													<div class="we-video-info">
														<ul>
															<li>
																<span class="views" title="views">
																	<i class="fa fa-eye"></i>
																	<ins>1.2k</ins>
																</span>
															</li>
															<li>
																<div class="likes heart" title="Like/Dislike">❤ <span>2K</span></div>
															</li>
															<li>
																<span class="comment" title="Comments">
																	<i class="fa fa-commenting"></i>
																	<ins>52</ins>
																</span>
															</li>

															<li>
																<span>
																	<a class="share-pst" href="#" title="Share">
																		<i class="fa fa-share-alt"></i>
																	</a>
																	<ins>20</ins>
																</span>	
															</li>
														</ul>
														
													</div>
												</div>
												<div class="coment-area" style="display: block;">
													<ul class="we-comet">
                                                        Pas de commentaires pour l'instant
														{{-- <li>
															<div class="comet-avatar">
																<img src="assets/images/resources/admin.jpg" alt="">
															</div>
															<div class="we-comment">
																<h5><a href="time-line.html" title="">Jason borne</a></h5>
																<p>we are working for the dance and sing songs. this video is very awesome for the youngster. please vote this video and like our channel</p>
																<div class="inline-itms">
																	<span>1 year ago</span>
																	<a class="we-reply" href="#" title="Reply"><i class="fa fa-reply"></i></a>
																	<a href="#" title=""><i class="fa fa-heart"></i><span>20</span></a>
																</div>
															</div>

														</li> --}}
														
														<li>
															{{-- <a href="#" title="" class="showmore underline">Plus de commentaire+</a> --}}
														</li>
														<li class="post-comment">
															<div class="comet-avatar">
																<img src="assets/images/resources/admin.jpg" alt="">
															</div>
															<div class="post-comt-box">
																<form method="post">
																	<textarea placeholder="Ajouter un commentaire "></textarea>
																	<div class="add-smiles">
																		<div class="uploadimage">
																			<i class="fa fa-image"></i>
																			<label class="fileContainer">
																				<input type="file">
																			</label>
																		</div>
																		<span class="em em-expressionless" title="add icon"></span>
																		<div class="smiles-bunch">
																			<i class="em em---1"></i>
																			<i class="em em-smiley"></i>
																			<i class="em em-anguished"></i>
																			<i class="em em-laughing"></i>
																			<i class="em em-angry"></i>
																			<i class="em em-astonished"></i>
																			<i class="em em-blush"></i>
																			<i class="em em-disappointed"></i>
																			<i class="em em-worried"></i>
																			<i class="em em-kissing_heart"></i>
																			<i class="em em-rage"></i>
																			<i class="em em-stuck_out_tongue"></i>
																		</div>
																	</div>

																	<button type="submit"></button>
																</form>	
															</div>
														</li>
													</ul>
												</div>
											</div>

										</div>
									</div><!-- album post --> 
									@empty
										<p>Aucun post disponible.</p>
									@endforelse
                                   
                                </div>
                            </div><!-- centerl meta -->
                            <div class="col-lg-3">
                                <aside class="sidebar static right">
                                    <!-- page like widget -->
                                    <!-- explore events -->
                                    <!-- profile intro widget -->
                                    <div class="widget stick-widget">
                                        <h4 class="widget-title">Liens recents <a title="" href="#"
                                                class="see-all">Tout voir</a></h4>
                                        <ul class="recent-links">
                                            <li>
                                                <figure><img
                                                        src="{{ asset('assets/images/resources/FS_PREINSCRIPTIONS.jpg') }}"
                                                        alt=""></figure>
                                                <div class="re-links-meta">
                                                    <h6><a href="#" title="">Comment s'inscrire.</a></h6>
                                                    <span>il y a 2 semaines </span>
                                                </div>
                                            </li>
                                            <li>
                                                <figure><img src="{{ asset('assets/images/resources/DEUP_GID.jpg') }}"
                                                        alt=""></figure>
                                                <div class="re-links-meta">
                                                    <h6><a href="#" title="">Probleme de fermeture de
                                                            notes</a></h6>
                                                    <span>il y a 3 ans </span>
                                                </div>
                                            </li>
                                            <li>
                                                <figure><img
                                                        src="{{ asset('assets/images/resources/FS_PREINSCRIPTIONS.jpg') }}"
                                                        alt=""></figure>
                                                <div class="re-links-meta">
                                                    <h6><a href="#" title="">Probleme de releve de notes.</a>
                                                    </h6>
                                                    <span>il y 1 an</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div><!-- recent links -->
                                </aside>
                            </div><!-- sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- <script>
    $(document).ready(() => {
        $("form").submit(function(event) {
            event.preventDefault();
            // Désactiver le bouton de soumission
            $(this).find('button[type="submit"]').prop('disabled', true);

            // Récupérer les données du formulaire
            var formData = $(this).serialize();
            console.log('formData', formData);
            // Envoyer les données via AJAX
            $.ajax({
                type: "POST", // ou GET selon votre configuration
                url: "{{ route('post.store') }}", // l'url de soumission
                data: formData,
                // processData: false,
                // contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    });

                    setTimeout(() => {
                        window.location.href = '/';
                        // window.location.href = redirectUrl;
                    }, 1000);


                    // setTimeout(function() {
                    //     window.location.href = /profil;
                    // }, 2000);
                },
                error: function(e) {
                    console.log('message ', e.responseJSON.error);
                    Swal.fire({
                        title: 'Error!',
                        text: e.responseJSON.error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });

        });
    });
</script> --}}
@endsection
