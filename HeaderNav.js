
import { Link } from 'react-router-dom';

import { useNavigate } from 'react-router-dom';

import '../style/HeaderNav.css';


export const HeaderNav = () => {

    const navigate = useNavigate();

    return (
        <div>
            <ul className='HeaderNav'>
                <li>
                    <Link to="/">useState-Test</Link>
                </li>
                <li>
                    <Link to="/effect">useEffect-Test</Link>
                </li>
                <li>
                    <button onClick={() => { navigate('/post') }}>PostRequest-Test</button>
                </li>
                <li>
                    <button onClick={() => { navigate('/effect2') }}>useEffect-Test-2</button>
                </li>
            </ul>
        </div>
    );
};
