import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { Loader } from '../MiscComponents';

export default class Landing extends Component {
    constructor() {
        super();
        this.state = {
            isLoading: true,
            suggestedItems: [],
            categories: [],
            categoryFoods: [],
        };
        this.initDOM = this.initDOM.bind(this);
    }

    componentDidMount() {
        this.initDOM();
    }

    initDOM() {
        window.scrollTo(0, 0);
        axios.get("/api/market/").then(response => {
            const data = response.data;
            this.setState({
                suggestedItems: data.suggestedFoodItems,
                categories: data.allCategories,
                categoryFoods: data.allCatFoods,
                isLoading: false
            });
            // console.log("data", this.state.suggestedItems);
        }).catch(errors => {
            console.log(errors);
        })
    }

    render() {
        return (
            <div className="container-fluid m-0">
                <div className="row pad-0">
                    <div className="col-12 hero left-sided-panel p-0" style={{ backgroundSize: "cover", backgroundPosition: "center" }}>
                        <div className="overlay mask row m-0 p-5">
                            <div className="p-3 pad-tb-100 col-md-10">
                                <h1 className="white-text">
                                    Enjoy the best of deals,<br />
                                    <small>You deserve good meals</small>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row p-md-3 grey lighten-4">
                    {this.state.isLoading ?
                        <Loader text={"We're getting everything ready..."} />
                        :
                        <div className="col-12">
                            {this.state.suggestedItems.length > 0 ?
                                <React.Fragment>
                                    <h3 className="h1-strong">Suggested Items</h3>
                                    <div className="row pad-tb-50">
                                        {this.state.suggestedItems.map(function (food, i) {
                                            return (
                                                <Link to={"/market/foodItem/" + food.item.id} key={food.item.id} className="col-md-3 m-2 p-0" style={{ textDecoration: "none", color: "#555" }}>
                                                    <div className="card p-0">
                                                        <div className="card-body p-5" style={{ height: 150, backgroundImage: `url(${food.item.item_image})`, backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "top" }}>

                                                        </div>
                                                        <div className="card-footer p-3 white border-0">
                                                            <p className="lead h1-strong m-0">{food.item.item_name}</p>
                                                            <strong style={{ marginTop: -8 }}>{food.category.category_name}</strong><br />
                                                            <small style={{ marginTop: -8 }}>{food.subCategory.sub_category_name}</small>
                                                        </div>
                                                    </div>
                                                </Link>)
                                        })
                                        }
                                    </div>
                                </React.Fragment>
                                : null
                            }
                            {/* browse by categories */}
                            {this.state.categories.length > 0 ?
                                <React.Fragment>
                                    <h3 className="h1-strong m-0">Browse by Category</h3>
                                    <span>Shop from a variety of categories</span>
                                    {this.state.categoryFoods.map(function (catFood, i) {
                                        return (
                                            <div key={catFood.category.id} className="row p-2 pad-tb-50">
                                                <div className="col-12 navbar bg-red-orange p-2">
                                                    <h5 className="h5-responsive h1-strong m-0 white-text">{catFood.category.category_name}</h5>
                                                    <Link to={'/market/category/' + catFood.category.id} style={{ textDecoration: "none", color: "#fff" }} className="pull-right" >More</Link>
                                                </div>
                                                <div className="col-12 p-0">
                                                    <div className="row p-0">
                                                        {catFood.foodItems.map(function (food, i) {
                                                            return (
                                                                <Link to={"/market/foodItem/" + food.id} key={food.id} className="col-md-3 m-2 p-0" style={{ textDecoration: "none", color: "#555" }}>
                                                                    <div className="card p-0">
                                                                        <div className="card-body p-5" style={{ height: 150, backgroundImage: `url(${food.item_image})`, backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "top" }}>

                                                                        </div>
                                                                        <div className="card-footer p-3 white border-0">
                                                                            <p className="lead h1-strong m-0">{food.item_name}</p>
                                                                            {/* <strong style={{ marginTop: -8 }}>{food.category.category_name}</strong><br />
                                                                            <small style={{ marginTop: -8 }}>{food.subCategory.sub_category_name}</small> */}
                                                                        </div>
                                                                    </div>
                                                                </Link>)
                                                        })
                                                        }
                                                    </div>
                                                </div>
                                            </div>
                                        )
                                    })
                                    }
                                </React.Fragment>
                                : null}
                        </div>
                    }
                </div>
            </div>
        );
    }
}

