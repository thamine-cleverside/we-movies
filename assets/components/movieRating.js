import React from "react";

export default class MovieRating extends React.Component {

    render() {
        return (

            <div>
                <span>({this.props.ratingAverage})  </span>
                {[...Array(10).keys()].map((item, index) => {
                    return (Math.round(this.props.ratingAverage) > item) ? <span>★</span> : <span>☆</span>;
                })}
                <span>   {this.props.ratingNumber} Vote(s)</span>
            </div>
        )
    }
}
