import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Loader } from '../MiscComponents';
import Axios from 'axios';
import { Link } from 'react-router-dom';


export default class SearchResults extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoading: true,
            error: null,
            requestSuccess: false,
            searchKeyword: "",
            searchResults: []
        };
        this.searchFoodItems = this.searchFoodItems.bind(this);
    }

    componentWillMount() {
        this.searchFoodItems(this.props.match.params.query);
    }

    searchFoodItems(query) {
        window.scrollTo(0, 0);
        if (query != null) {
            this.setState({ isLoading: true, searchKeyword: query });
            Axios.get('/api/market/searchFoodItems?q=' + escape(query)).then(
                response => {
                    const data = response.data;
                    this.setState({
                        isLoading: false,
                        error: null,
                        requestSuccess: true,
                        searchResults: data.foodItems
                    });
                }
            ).catch(errors => {
                this.setState({
                    isLoading: false,
                    category: null,
                    subCategories: [],
                    error: errors.message,
                    requestSuccess: false
                });
                console.log(errors);
            });
        }
    }

    render() {
        return (
            <div className="container-fluid">
                {this.state.isLoading ?
                    <Loader text={"We're searching through our store..."} />
                    :
                    // check if request was successful
                    this.state.requestSuccess ?
                        <React.Fragment>
                            <div className="row pad-0">
                                <div class="col-md-11 mx-auto p-3">
                                    <h4 class="h4-responsive h1-strong dark-grey-text">Search Results</h4>
                                    <p class="lead dark-grey-text">Showing results for <strong>&quot;{this.state.searchKeyword}&quot;</strong></p>
                                </div>
                            </div>
                            {/* <!-- search bar  --> */}
                            <div className="row m-4">
                                <div className="col-md-8 mx-auto shadow-lg">
                                    <form className="row" method="GET" action="/market/search/items/">
                                        <div className="col-9 p-3">
                                            <div className="md-form p-0 m-0">
                                                <input className="form-control" type="text" name="q" placeholder="Search food items" required />
                                            </div>
                                        </div>
                                        <div className="col-3 p-3">
                                            <button type="submit" className="btn btn-danger bg-red-orange white-text capitalize m-1"><span className="fa fa-search"></span>&nbsp;Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {/* <!-- /search bar  --> */}
                            
                            <div class="row p-3">
                                {this.state.searchResults.map((function (food, i) {
                                    return (
                                        <Link to={"/market/foodItem/" + food.id} key={food.id} className="col-md-3 m-2 p-0" style={{ textDecoration: "none", color: "#555", minHeight: "100%" }}>
                                            <div className="card p-0" style={{ height: "100%" }}>
                                                <div className="card-body p-5" style={{ height: 150, backgroundImage: `url(${food.item_image})`, backgroundSize: "cover", backgroundRepeat: "no-repeat", backgroundPosition: "top" }}>

                                                </div>
                                                <div className="card-footer p-3 white border-0">
                                                    <p className="m-0" style={{ fontWeight: "bold", fontFamily: "inherit" }}>{food.item_name}</p>
                                                    {/* <strong style={{ marginTop: -8 }}>{food.category.category_name}</strong><br />
                                                                            <small style={{ marginTop: -8 }}>{food.subCategory.sub_category_name}</small> */}
                                                </div>
                                            </div>
                                        </Link>
                                    )
                                }))
                                }
                            </div>
                        </React.Fragment>
                        :
                        // show error message
                        <div className="row pad-tb-100">
                            <div className="col-12" style={{ textAlign: "center" }}>
                                <span className="fa fa-info-circle fa-5x grey-text"></span>
                                <p className="lead grey-text">{this.state.error}</p>
                            </div>
                        </div>
                }
            </div>
        );
    }
}

