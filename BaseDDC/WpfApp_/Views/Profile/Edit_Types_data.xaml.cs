using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Forms;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using BaseDTO;
using RestSharp;

namespace WpfApp_.Views.Profile
{
    /// <summary>
    /// Логика взаимодействия для Edit_types_data.xaml
    /// </summary>
    public partial class Edit_types_data : Window
    {

        List<DTO_Type_of_house> _houseTypes;
        List<DTO_Heating_Type> _heatingTypes;
        DTO_Profile_Get _profile;

        public Edit_types_data(DTO_Profile_Get profile)
        {
            InitializeComponent();
            this._profile = profile;

            _houseTypes = StaticInfoCollections.InfoCollections.type_Of_Houses;
            _heatingTypes = StaticInfoCollections.InfoCollections.heating_Types;

            house_type.DisplayMemberPath = "title";
            house_type.SelectedValuePath = "id";
            type_heating.DisplayMemberPath = "title";
            type_heating.SelectedValuePath = "id";
            
            house_type.ItemsSource = _houseTypes;
            type_heating.ItemsSource = _heatingTypes;

            type_heating.SelectedValue = _profile.IdTypeHeating;
            house_type.SelectedValue = _profile.IdTypeOfHouse;

            isMigrant.IsChecked = Convert.ToBoolean(_profile.ForcedMigrant);
            isDestroyHouse.IsChecked = Convert.ToBoolean(_profile.DestroyedHouse);


        }

        private async void Edit_Types_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                int profile_id = _profile.Id;
                sbyte migrant = Convert.ToSByte(isMigrant.IsChecked);
                sbyte DestroyedHouse = Convert.ToSByte(isDestroyHouse.IsChecked);
                int houseType = (int)house_type.SelectedValue;
                int heatingType = (int)type_heating.SelectedValue;
                
                DialogResult dialogResult = System.Windows.Forms.MessageBox.Show("Сохранение", "Сохранить изменения?", MessageBoxButtons.YesNo);
                if (dialogResult == System.Windows.Forms.DialogResult.Yes)
                {
                    string route = String.Format("/Profile/ChngStatuses/{0}/{1}/{2}/{3}/{4}", profile_id, migrant, DestroyedHouse, houseType, heatingType);
                    IRestResponse<object> response = await RestAPI.PostRestAsync<object>(route);
                    if(response.StatusCode == System.Net.HttpStatusCode.OK) {
                        System.Windows.Forms.MessageBox.Show("Сохранено");
                    } 
                    this.Close();
                }
            }
            catch (Exception ex)
            {
                System.Windows.MessageBox.Show("Ошибка:" + ex.Message + "\n В методе:" + ex.TargetSite);
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}
