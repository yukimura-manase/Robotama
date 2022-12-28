import React, { useEffect, useState } from "react";
import DeckGL, { MapController } from "deck.gl";
import { RenderLayers } from "./components/RenderLayers";

const App = () => {

  // ViewPort の設定値-Object であり、State管理
  const [viewport, setViewport] = useState({
    width: window.innerWidth,       // 1. Windowの幅を取得してSet: 全画面表示
    height: window.innerHeight,     // 2. Windowの高さを取得してSet: 全画面表示
    longitude: -3.2943888952729092, // 経度
    latitude: 53.63605986631115,    // 緯度
    zoom: 6,      // Zoom
    maxZoom: 16,  // max-Zoom
    minZoom: 3,
    pitch: 45,    // 角度(傾き)
    bearing: 0
  });

  console.log({viewport});

  // resize-Event
  useEffect(() => {

    console.log('useEffect');

    const handleResize = () => {
      setViewport((v) => {

        // console.log('setViewport', v);
        return {
          ...v,
          width: window.innerWidth,
          height: window.innerHeight
        };
      });
    };
    handleResize();
    window.addEventListener("resize", handleResize);

    // クリーンアップ関数
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  return (

    <div className="App">
      <DeckGL
        layers={RenderLayers({
          tileURL: "https://c.tile.openstreetmap.org/{z}/{x}/{y}.png"
          // tileURL: 'https://cyberjapandata.gsi.go.jp/xyz/seamlessphoto/{z}/{x}/{y}.jpg',
        })}
        controller={{ type: MapController, dragRotate: false }}
        initialViewState={viewport}
      />
      <div className="attribution">
        <a href="http://www.openstreetmap.org/about/" target="_blank" rel="noopener noreferrer">
          © OpenStreetMap
        </a>
      </div>
    </div>
  );
};

export default App;




// < 参考・引用🔥 >

// 1. create-react-appコマンドのdeck.glテンプレートを作りました。
// https://gunmagisgeek.com/blog/deck-gl/7084



// 2. bboxfinderのようなサービスを使うことでbboxの値を調べる事ができます。
// https://gunmagisgeek.com/blog/other/7845



// 3. geojson.io
// https://geojson.io/#map=2/26.21/140.47



