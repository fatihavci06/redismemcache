<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class ApiController extends Controller
{
    public function redis()
    {
        //redis db işlemleri
        //redis kurulumu yapıldıktan sonra bu işlemler yapılır.confi/database.php de  'database' => env('REDIS_DB', '1'),  1 olarak ayarlanırsa cacheden çeker 0 yaparsak redis dbden çekeriz.cache için aşağıdaki test fonksiyonundaki işlemler geçerlidir.bu fonksion çalışmaz
        Redis::set('fulname','fatih avci');// bir değişken gibi atadık redise cachleme yaptık
        Redis::get('fulname');// fulname keyinde değeri çektik yani fatih avciyi
         //rediste tüm keyleri çektik. cachleme keylerde ypılıyor

        Redis::set('Istanbul:2021:02:20:12:00:kamu',2); //buradaki Istanbul... key value 2 dir
        Redis::set('Istanbul:2021:02:20:12:00:yetiskin',5);
        Redis::set('Istanbul:2021:02:20:12:00:cocuk',7);
        $keys=Redis::keys('Istanbul:2021:02:20:12:00:*');
        dd($keys);
        foreach ($keys as $key ) {
            $db=Redis::get($key); //keuin değerini çektik
            $db--; //değeri 1 azalttık.
            Redis::set($key,$db);//burada yeni değer ataması gerçekleştirdik,
            echo Redis::get($key); //burada tüm keylerib yazdırdık

        }
       return  Redis::get('fulname');

    }
    public function test()
    {
       /* if(Cache::has('posts')){
            return Cache::get('posts'); //eğer post keyine sahipsek döndür yoksa yok yaz 
        }
        else{
            return 'yok';
        }*/
        ///Eğer posts keyinde cacheleme yapılmışssa döndür.yoksa cachleme işlemi yapıyoruz

        /*
        istediğimiz datayı istediğimiz cache yöntemiyle işyebiliriz.
        her seferinde gidip .env içerisinde CACHE_DRIVER= 'ı değiştrimeye gerek duymadan.Örneğin datanın bir kısmını memcached ile cachledik.Bir kısmını ise file ile cacledik
        $cache=Cache::store('memcached'); //burada anlık olarak memcached seçmiş olduk
        Cache::put('postsCount',count($post),120);
        '

        */
        /*Cache::forever('test',10); //sonsuza dek test keyinde cachleme dursun
        Cache::forget('test');//test keyindeki cachlemeyi unut
        Cache::flush();//butün cache temizle
        Cache::pull('test');//al ve sil */
        if(Cache::has('postsCount')){
            Cache::increment('postsCount',5);//postcount eğer integersa 5 artır 
          //postcount eğer integersa 1 düşür  Cache::decrement('postsCount');
            return Cache::get('postsCount');
        }
        $post=Post::all();
        Cache::put('postsCount',count($post),120);
        return count($post);



     /*   return Cache::remember('posts',120,function(){
            return Post::all();  //eğer posts keyinde Post::all() yoksa posts keyine ekle eğer varsa posts keyinden getir anlamına gelir ,120 saniye boyunca geçerlidir
        });*/
            
    }
}
