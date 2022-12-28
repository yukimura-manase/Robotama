import { Deck } from '@deck.gl/core';
import { TileLayer, BitmapLayer } from 'deck.gl';

// @ts-ignore
import { ParticleLayer } from 'deck.gl-particle';
import GL from '@luma.gl/constants';

// マップの境界ボックスの座標[ west, south, east, north ]
const bounds = [119.96875, 22.375, 150.03125, 47.625];


// 
// 「レイヤー」は、deck.gl のコア コンセプトです。Deck.gl レイヤーは、データムのコレクションを取得し、それぞれを位置、色、押し出しなどに関連付けて、マップ上にレンダリングする、パッケージ化された視覚化タイプです。


// [ 1. TileLayer-Instance ]

// TileLayerは、サードパーティのラスタタイル(地図タイル)を読み込んで表示するためのレイヤーです。

// 1. new TileLayer で、サードパーティーの地図タイルを読み込む！
const background = new TileLayer({

    // レイヤーID: 任意のレイヤー名を指定。レンダリングの基盤となるためユニークなIDを指定する
    id: 'background',
    
    // data: レイヤーで描画するデータセットを渡すプロパティ
    // dataプロパティに地図タイルのURLを指定する => JSONの場合はURLで指定することもできる
    data: 'https://cyberjapandata.gsi.go.jp/xyz/seamlessphoto/{z}/{x}/{y}.jpg',

    // Zoomやタイルのサイズ設定
    minZoom: 0,
    maxZoom: 17,
    tileSize: 256, // タイルのピクセル ディメンション。通常は 2 の累乗です。

    // マップの境界ボックスの座標[ west, south, east, north ]
    // bounds: 境界
    extent: bounds as any,

    // ロードされたタイル・データは、renderSubLayers　によって返されたレイヤでレンダリングされます。
    renderSubLayers: (props) => {

        const {
            // bbox: BoundsBox(境界Box)の略
            bbox: { west, south, east, north },
        } = props.tile;


        // 2. BitmapLayer-Instance

        // BitmapLayerは画像を表示するためのシンプルなレイヤー

        // BitMap(ビットマップ)とは、画像データを「座標と色」で覚えておくデータ形式のこと。
        return new BitmapLayer(props, {
            data: null,
            image: props.data,
            bounds: [west, south, east, north],
        });
    },
});

// 3. Image-Instance
// 表示するImage のインスタンスを作成する
const image = new Image();

// image に対して、onloadイベント
image.onload = () => {

    // 4. ParticleLayer-Instance
    const particle = new ParticleLayer({
        id: 'particle',
        maxAge: 40,
        numParticles: 1500,
        image,
        speedFactor: 1.0,
        width: 2,
        opacity: 0.5,
        animate: true,
        bounds,
        textureParameters: {
            [GL.TEXTURE_WRAP_S]: GL.CLAMP_TO_EDGE,
        },
    });

    // 5. Deck-Instance
    new Deck({
        initialViewState: {
            longitude: 136,
            latitude: 37.78,
            zoom: 4,
        },
        controller: true,
        layers: [background, particle],
        _animate: true,
    });
};

// Imageの元となる画像
image.src = 'wind_rgb.png';






// 0. ざっくり理解するDeck.gl
// https://gunmagisgeek.com/slide/foss4gTokai2019/zakkuriDeckgl/#/


// タイルレイヤー
// https://deck.gl/docs/api-reference/geo-layers/tile-layer



// Deck.gl の世界へようこそ！ ３歩でわかる お手軽 データビジュアライゼーション
// https://qiita.com/dsudo/items/b1db5f965d1eb58e8f38


// deck.glで衛星写真(画像)を地図に掲載する
// https://gunmagisgeek.com/blog/other/7845





// 1. 気象庁GRIB2データをGDALで引っ叩くための下ごしらえ・可視化例
// https://qiita.com/Kanahiro/items/de95428b9ec7a534c9c9

// 2. 上記のGitHub
// https://github.com/Kanahiro/japan-windmap-example

// 3. deck.glでmapboxサービス以外のベースマップを使用する
// https://gunmagisgeek.com/blog/deck-gl/6431


// 4. Deck-GL-Doc: レイヤーの使用
// https://deck.gl/docs/developer-guide/using-layers





