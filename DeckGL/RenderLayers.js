import { TileLayer, BitmapLayer } from "deck.gl";


// マップの境界ボックスの座標[ west, south, east, north ]
const bounds = [119.96875, 22.375, 150.03125, 47.625];


// 1. OpenStreetMapの地図タイルを読み込む
export function RenderLayers(props) {

    console.log('renderLayers');

    const { tileURL } = props;

    const tileLayer = new TileLayer({
        data: tileURL,

        minZoom: 0,
        maxZoom: 19,
        tileSize: 256,

        // extent: bounds,

        renderSubLayers: (props) => {
            const {
                bbox: { west, south, east, north }
            } = props.tile;

            return new BitmapLayer(props, {
                data: null,
                image: props.data,
                bounds: [west, south, east, north]
            });
        }
    });

    return [tileLayer];
}
