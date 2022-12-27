
const Footer = () => {
    return (
        <footer>
        <div className='wrapper'>
          <h2>
            <a href="https://www.msil.go.jp/msil/htm/topwindow.html"><img src="https://umishiru.ssl-center.jp/youbou/images/footer_logo.png" alt="footer-logo" /></a>
          </h2>
          <nav>
            <ul>
              <li><a href="https://www.msil.go.jp/msil/Data/ReadMe.pdf">操作説明</a></li>
              <li><a href="https://www.msil.go.jp/msil/htm/toiawase.html">お問い合わせ</a></li>
              <li><a href="https://www.msil.go.jp/msil/htm/Link.html">リンク集</a></li>
              <li><a href="https://www.msil.go.jp/msil/Data/leaflet_ja.pdf">紹介リーフレット</a></li>
              <li><a href="#">利用規約</a></li>
              <li><a href="https://www.kaiho.mlit.go.jp/policy/privacy_policy.html">プライバシーポリシー</a></li>
            </ul>
            <p className='copyright'>Copyright（C）Japan Coast Guard, All Rights Reserved.</p>
          </nav>
        </div>
      </footer>
    )
}

export default Footer;
