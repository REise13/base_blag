using BaseDTO;
using Newtonsoft.Json;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Windows;

namespace WpfApp_.Views.Profile
{
    public partial class Prof : Window
    {
        private DTO_Profile_Get _profile;
        private List<DTO_Help_Get> _helps;
        private string _profileId;

        public Prof(string profile_id_)
        {
            InitializeComponent();
            Category_listbox.DisplayMemberPath = "title";
            Category_listbox.SelectedValuePath = "id";
            Trainings_listbox.DisplayMemberPath = "title";
            Trainings_listbox.SelectedValuePath = "id";
            Needs_listbox.DisplayMemberPath = "title";
            Needs_listbox.SelectedValuePath = "id";
            
            if(RestAPI.User.Role.title != "admin")
            {
                EditFamilyButton.IsEnabled = false;
                EditRegisterInfoButton.IsEnabled = false;
                EditTypesButton.IsEnabled = false;
            }


            this._profileId = profile_id_;
            Refresh();
        }

       

        private List<DTO_Need> GetNeeds(DTO_Profile_Get profile)
        {
            var need_list = new List<DTO_Need>();

            profile
                .CrossNeed
                .ToList()
                .ForEach((item) =>
                {
                    StaticInfoCollections.InfoCollections.needs
                        .ForEach((need) =>
                        {
                            if (item.IdNeed == need.id)
                            {
                                need_list.Add(need);
                            }
                        }
                        );
                });
            return need_list;
        }

        private List<DTO_Training> GetTrainings(DTO_Profile_Get profile)
        {
            var training_list = new List<DTO_Training>();

            profile
                .CrossTraining
                .ToList()
                .ForEach((item) =>
                {
                    StaticInfoCollections.InfoCollections.trainings
                        .ForEach((training) =>
                        {
                            if (item.IdTraining == training.id)
                            {
                                training_list.Add(training);
                            }
                        }
                        );
                });
            return training_list;
        }

        private List<DTO_Category> GetCategories(DTO_Profile_Get profile)
        {
            var category_list = new List<DTO_Category>();

            profile
                .CrossCategory
                .ToList()
                .ForEach((item) =>
                {
                    StaticInfoCollections.InfoCollections.categories
                        .ForEach((category) =>
                        {
                            if (item.IdCategory == category.id)
                            {
                                category_list.Add(category);
                            }
                        }
                        );
                });
            return category_list;
        }


        private List<Trainings_for_listbox> GetList()
        {
            List<Trainings_for_listbox> list = new List<Trainings_for_listbox>();
            foreach (var item in _profile.CrossTraining)
            {
                var training = StaticInfoCollections.InfoCollections.trainings.Where(x => x.id == item.IdTraining).FirstOrDefault();

                string date = item.DateTraining.Day + "\\" + item.DateTraining.Month + "\\" + item.DateTraining.Year;

                list.Add(new Trainings_for_listbox() { title = training.title + " - "+ date, id = training.id });
            }
            return list;
        }




        private void Edit_People_Click(object sender, RoutedEventArgs e)
        {
            var people_get = new DTO_People_Get()
            {
                Id = _profile.IdPeople,
                Name = _profile.IdPeopleNavigation.Name,
                SName = _profile.IdPeopleNavigation.SName,
                Patr = _profile.IdPeopleNavigation.Patr,
                IdGenderNavigation = _profile.IdPeopleNavigation.IdGenderNavigation,
                Email = _profile.IdPeopleNavigation.Email,
                IdCityNavigation = _profile.IdPeopleNavigation.IdCityNavigation,
                Inn = _profile.IdPeopleNavigation.Inn,
                Passport = _profile.IdPeopleNavigation.Passport,
                Phone = _profile.IdPeopleNavigation.Phone,
                Year = _profile.IdPeopleNavigation.Year
            };

            new Edit_People_data(people_get).ShowDialog();
            Refresh();
        }

        private void Edit_Types_Click(object sender, RoutedEventArgs e)
        {
            new Edit_types_data(_profile).ShowDialog();
            Refresh();
        }

        private void Edit_Category_Click(object sender, RoutedEventArgs e)
        {
            new Edit_Category_data(GetCategories(_profile),Convert.ToInt32(_profileId)).ShowDialog();
            Refresh();
        }

        private void Edit_Needs_Click(object sender, RoutedEventArgs e)
        {
            new Edit_Need_data(GetNeeds(_profile), Convert.ToInt32(_profileId)).ShowDialog();
            Refresh();
        }

        private void Edit_Trainings_Click(object sender, RoutedEventArgs e)
        {
            new Edit_Training_data(GetTrainings(_profile), Convert.ToInt32(_profileId)).ShowDialog();
            Refresh();
        }

        private void Add_Help_Click(object sender, RoutedEventArgs e)
        {
            new Add_Help(Convert.ToInt32(_profileId)).ShowDialog();
            Refresh();
        }

        private async void Refresh()
        {
            StaticInfoCollections.GetInfoCollections();
            
            IRestResponse<DTO_Profile_Get> responseProfile = await RestAPI.PostRestAsync<DTO_Profile_Get>("/Profile/GetById/" + _profileId);
            _profile = responseProfile.Data;

            IRestResponse<List<DTO_Help_Get>> responseHelps = await RestAPI.PostRestAsync<List<DTO_Help_Get>>("/Help/GetById/" + _profileId);
            _helps = responseHelps.Data;
            
            Data_Projects.ItemsSource = _helps;
            
            Name.Text = _profile.IdPeopleNavigation.Name;
            SecondName.Text = _profile.IdPeopleNavigation.SName;
            Patr.Text = _profile.IdPeopleNavigation.Patr;
            Gender.Content = _profile.IdPeopleNavigation.IdGenderNavigation.title;
            Year.Text = Convert.ToString(_profile.IdPeopleNavigation.Year);
            INN_text.Text = _profile.IdPeopleNavigation.Inn;
            Email.Text = _profile.IdPeopleNavigation.Email;
            Phone.Text = _profile.IdPeopleNavigation.Phone;
            City.Content = _profile.IdPeopleNavigation.IdCityNavigation.title;
            Pasport.Text = _profile.IdPeopleNavigation.Passport;
            isMigrant.IsChecked = Convert.ToBoolean(_profile.ForcedMigrant);
            isDestroyHouse.IsChecked = Convert.ToBoolean(_profile.DestroyedHouse);
            type_heating.Text = _profile.IdTypeHeatingNavigation.title;
            house_type.Text = _profile.IdTypeOfHouseNavigation.title;
            Category_listbox.ItemsSource = GetCategories(_profile);
            Trainings_listbox.ItemsSource = GetList();
            Needs_listbox.ItemsSource = GetNeeds(_profile);
            
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

    }
}
