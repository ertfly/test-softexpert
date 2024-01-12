import { bindActionCreators } from "redux";
import { connect } from "react-redux";

let Dashboard = () => {
    return (
        <div className="container-fluid p-4">
            <div className="d-flex justify-content-between">
                <div>
                    <h2 className="card-title">Dashboard</h2>
                    <p className="card-text">Resumo de vendas.</p>
                </div>
            </div>
        </div>
    )
}

const mapStateToProps = ({  }) => ({
    
});

const mapDispatchToProps = (dispatch) => ({
    methods: bindActionCreators(
        {
            
        },
        dispatch
    )
});

export default connect(mapStateToProps, mapDispatchToProps)(Dashboard)