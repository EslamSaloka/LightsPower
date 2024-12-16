@php
    $post = \App\Models\Post::find($id);
@endphp
@if (is_null($post))
    <div class="alert alert-danger" role="alert">
        المنشور غير موجود
    </div>
    <?php
        return;
    ?>
@endif
<div class="col-lg-12">
    <h4>
        بيانات المنشور الذي تمت مشاركته
    </h4>
    <div class="">
        <div class="table-responsive">
            <table class="table project-list-table table-nowrap align-middle table-borderless">
                <tbody>
                    <tr>
                        <td>
                            @lang('الإنتقال للإعلان')
                        </td>
                        <td>
                            <a href="{{ route('admin.posts.show',$post->id) }}">
                                عرض المنشور الأصلي
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('المستخدم')
                        </td>
                        <td>
                            @canAny('customers.edit')
                                <a href="{{ route('admin.customers.edit',$post->user_id) }}">
                                    {{ $post->user->username ?? '' }}
                                </a>
                            @else
                                {{ $post->user->username ?? '' }}
                            @endcanAny
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('الإعجابات')
                        </td>
                        <td>
                            {{ $post->likes()->count() ?? '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('Created At')
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() ?? '' }}
                        </td>
                    </tr>
                    @if ($post->post_type_id == 0)
                        <tr>
                            <td>
                                @lang('صور المنشور')
                            </td>
                            <td>
                                <ul>
                                    @foreach($post->images as $image)
                                        <li>
                                            <img class="clickImage" src="{{ $image->display_image }}" width="50" alt="Thumb-1">
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="lay">
    <ul class="notification">
        <li>
            <div class="notification-icon">
                <a href="javascript:void(0);"></a>
            </div>
            <div class="notification-body">
                <div class="media mt-0">
                    <div class="media-body ms-3 d-flex">
                        <div class="">
                            <p class="mb-0 tx-13 text-muted">{!! $post->display_description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @if ($post->threads()->count() > 0)
            @foreach ($post->threads as $item)
                <li>
                    <div class="notification-icon">
                        <a href="javascript:void(0);"></a>
                    </div>
                    <div class="notification-body">
                        <div class="media mt-0">
                            <div class="media-body ms-3 d-flex">
                                <div class="">
                                    <p class="mb-0 tx-13 text-muted">
                                        <a href="{{ route("admin.posts.show",$item->id) }}">
                                            {{ $item->display_description }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
