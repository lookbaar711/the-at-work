<li class="dropdown notifications-menu clear-badge">
    <input type="hidden" name="badge" id="badge" value="{{ $count_noti }}">
    <a href="#" class="dropdown-toggle" id="add_noti" data-toggle="dropdown">
        <i class="livicon" data-name="bell" data-loop="true" data-color="#e9573f"
           data-hovercolor="#e9573f" data-size="28"></i>
        
        @if($count_noti > 0)
            <span class="label label-warning header-icons-noti" id="show_noti">{{ $count_noti }}</span>
        @endif
    </a>
    <ul class=" notifications dropdown-menu drop_notify">
        <li class="dropdown-title">You have {{ $count_noti }} notifications</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu" id="header_noti">
                @if(isset($admin_noti))
                    <?php $count_noti = 1; ?>
                    @foreach($admin_noti as $noti)

                        @if($noti->noti_type == 'register_teacher')
                            <li>
                                <i class="danger"></i>
                                <?php $show_text = $noti->member_fullname.' ได้ลงทะเบียนผู้สอนแล้ว'; ?>
                                <a href="{{ URL::to('backend/members/new') }}">{{ mb_substr($show_text, 0, 30, 'UTF-8').'...' }}</a>
                                <small class="pull-right">
                                    {{ date('d/m/Y H:i', strtotime($noti->created_at)) }}
                                </small>
                            </li>                            
                        @elseif($noti->noti_type == 'topup_coins')
                            <li>
                                <i class="warning"></i>
                                <?php $show_text = $noti->member_fullname.' ได้แจ้งเติม Coins เข้ามาในระบบ'; ?>
                                <a href="{{ URL::to('backend/coins/fill') }}">{{ mb_substr($show_text, 0, 30, 'UTF-8').'...' }} </a>
                                <small class="pull-right">
                                    {{ date('d/m/Y H:i', strtotime($noti->created_at)) }}
                                </small>
                            </li>
                        @elseif($noti->noti_type == 'withdraw_coins')
                            <li>
                                <i class="info"></i>
                                <?php $show_text = $noti->member_fullname.' ได้แจ้งถอน Coins เข้ามาในระบบ'; ?>
                                <a href="{{ URL::to('backend/coins/revoke') }}">{{ mb_substr($show_text, 0, 30, 'UTF-8').'...' }} </a>
                                <small class="pull-right">
                                    {{ date('d/m/Y H:i', strtotime($noti->created_at)) }}
                                </small>
                            </li>
                        @elseif($noti->noti_type == 'refund')
                            <li>
                                <i class="primary"></i>
                                <?php $show_text = $noti->member_fullname.' ได้แจ้งขอคืนเงิน เข้ามาในระบบ'; ?>
                                <a href="{{ URL::to('backend/coins/refund') }}">{{ mb_substr($show_text, 0, 30, 'UTF-8').'...' }} </a>
                                <small class="pull-right">
                                    {{ date('d/m/Y H:i', strtotime($noti->created_at)) }}
                                </small>
                            </li>
                        
                        @endif
                        
                        <?php $show_noti++; ?>
                        
                    @endforeach
                @endif


                {{-- <li>
                    <i class="livicon danger" data-n="timer" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">สมชาย ใจดี ได้ลงทะเบียนผู้สอนแล้ว</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        Just Now
                    </small>
                </li> --}}
                
                {{-- <li>
                    <i class="livicon success" data-n="gift" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">Jef's Birthday today</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        Few seconds ago
                    </small>
                </li>
                <li>
                    <i class="livicon warning" data-n="dashboard" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">out of space</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        8 minutes ago
                    </small>
                </li>
                <li>
                    <i class="livicon bg-aqua" data-n="hand-right" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">New friend request</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        An hour ago
                    </small>
                </li>
                <li>
                    <i class="livicon danger" data-n="shopping-cart-in" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">On sale 2 products</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        3 Hours ago
                    </small>
                </li>
                <li>
                    <i class="livicon success" data-n="image" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">Lee Shared your photo</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        Yesterday
                    </small>
                </li>
                <li>
                    <i class="livicon warning" data-n="thumbs-up" data-s="20" data-c="white"
                       data-hc="white"></i>
                    <a href="#">David liked your photo</a>
                    <small class="pull-right">
                        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
                        2 July 2014
                    </small>
                </li> --}}
            </ul>
        </li>
        <li class="footer">
            <a href="#">View all</a>
        </li>
    </ul>
    <input type="hidden" name="admin_id" id="admin_id" value="{{ Auth::guard('web')->user()->_id }}">
</li>