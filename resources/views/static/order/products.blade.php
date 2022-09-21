<fieldset class="mb-3" data-async="">
    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <div class="row form-group align-items-baseline">
            <div class="col-12 col-md form-group mb-md-0">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <th scope="row">{{$product->id}}</th>
                            <td>{{$product->title}}</td>
                            <td>{{$product->pivot->count}}</td>
                            <td>{{$product->pivot->price}}</td>
                            <td>
                                <a href="{{route('order.product.delete',[$order,$product])}}" class="">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="#df1919">
                                        <path
                                            d="M28.025 4.97l-7.040 0v-2.727c0-1.266-1.032-2.265-2.298-2.265h-5.375c-1.267 0-2.297 0.999-2.297 2.265v2.727h-7.040c-0.552 0-1 0.448-1 1s0.448 1 1 1h1.375l2.32 23.122c0.097 1.082 1.019 1.931 2.098 1.931h12.462c1.079 0 2-0.849 2.096-1.921l2.322-23.133h1.375c0.552 0 1-0.448 1-1s-0.448-1-1-1zM13.015 2.243c0-0.163 0.133-0.297 0.297-0.297h5.374c0.164 0 0.298 0.133 0.298 0.297v2.727h-5.97zM22.337 29.913c-0.005 0.055-0.070 0.11-0.105 0.11h-12.463c-0.035 0-0.101-0.055-0.107-0.12l-2.301-22.933h17.279z"></path>
                                    </svg>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</fieldset>
