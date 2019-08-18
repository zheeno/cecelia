import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Link, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import { CartSlip } from './components/MiscComponents';
import Axios from 'axios';

import Landing from './components/marketPlace/Landing';
import SubCategory from './components/marketPlace/SubCategory';
import ItemDetail from './components/marketPlace/ItemDetail';
import FoodCategory from './components/marketPlace/FoodCategory';



export default class Index extends Component {
    constructor() {
        super();
        this.state = {
            activeTab: 1,
            addingItem: false,
            token: localStorage.getItem("cartToken"),
            cartItems: [],
            cartData: null
        };
        this.genCartToken = this.genCartToken.bind(this);
        this.getCartItems = this.getCartItems.bind(this);
        this.addItem = this.addItem.bind(this);
        this.removeItem = this.removeItem.bind(this);
    }

    componentDidMount() {
        this.genCartToken();
    }

    genCartToken() {
        if (this.state.token == null) {
            this.setState({ addingItem: true });
            Axios.get('/api/market/genCartToken').then(
                response => {
                    const data = response.data;
                    this.setState({
                        token: data.token
                    });
                    localStorage.setItem("cartToken", data.token);
                    this.getCartItems();
                }
            ).catch(errors => {
                console.log(errors);
            });
        } else {
            this.getCartItems();
        }
    }

    getCartItems() {
        if (this.state.token != null) {
            this.setState({ addingItem: true });
            Axios.get('/api/market/getCartItems?_token=' + this.state.token).then(
                response => {
                    const data = response.data;
                    this.setState({
                        addingItem: false,
                        cartItems: data.cart,
                        cartData: data.cartData
                    });
                }
            ).catch(errors => {
                this.setState({addingItem: false});
                console.log(errors);
            });
        }
    }


    addItem(item) {
        console.log("Item -> Router", item);
        this.setState({ addingItem: true });
        Axios.post('/api/market/addItemToCart?item_id=' + item.item_id + "&qty=" + item.qty + "&token=" + this.state.token).then(
            response => {
                const data = response.data;
                this.setState({
                    addingItem: false,
                    cartItems: data.cart,
                    cartData: data.cartData
                });
                localStorage.setItem("cartToken", data.cartData.token);
            }
        ).catch(errors => {
            this.setState({addingItem: false});
            console.log(errors);
        });
    }


    removeItem(itemId) {
        this.setState({ addingItem: true });
        Axios.get('/api/market/removeItemFromCart?item_id=' + itemId).then(
            response => {
                const data = response.data;
                this.setState({
                    addingItem: false,
                    cartItems: data.cart,
                    cartData: data.cartData
                });
                return true;
            }
        ).catch(errors => {
            this.setState({addingItem: false});
            console.log(errors);
            return false;
        });
    }

    render() {
        return (
            <div className="container-fluid p-2" style={{ overflowX: "hidden" }} >
                <Router>
                    <div className="row p-0">
                        <div className="col-md-8 p-0">
                            {/* navbar */}
                            <div className="navbar m-0 navbar-dark navbar-expand bg-red-orange" style={{ width: "100%" }}>
                                {/* <!-- Navbar brand --> */}
                                <Link className="navbar-brand h1-strong fa-2x" to="/market">Market Place</Link>
                                <div className="collapse navbar-collapse" id="navbarSupportedContent-444">
                                    <form className="form-inline ml-auto">
                                        <div className="md-form my-0">
                                            <input className="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" />
                                        </div>
                                    </form>
                                </div>
                                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-444"
                                    aria-controls="navbarSupportedContent-444" aria-expanded="false" aria-label="Toggle navigation">
                                    <span className="fa fa-caret-down"></span>
                                </button>
                            </div>
                            {/* routes */}
                            <Route path="/market" exact component={Landing} />
                            <Route path="/market/category/:id" exact render={(props) => <FoodCategory {...props} />} />
                            <Route path="/market/category/sub/:id" exact render={(props) => <SubCategory {...props} />} />
                            <Route path="/market/foodItem/:id" exact render={(props) => <ItemDetail {...props} addItem={(item) => { this.addItem(item) }} removeItem={(itemId) => this.removeItem(itemId)} isAdding={this.state.addingItem} />} />
                        </div>
                        <div className="col-md-4 mx-auto" style={{ minHeight: "100%" }}>
                            <CartSlip cartData={this.state.cartData} cartItems={this.state.cartItems} isAdding={this.state.addingItem} removeItem={(itemId) => this.removeItem(itemId)} />
                        </div>
                    </div>
                </Router>
            </div>
        );
    }
}

if (document.getElementById('index')) {
    ReactDOM.render(<Index />, document.getElementById('index'));
}

