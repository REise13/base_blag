using BaseDTO;
using RestSharp;
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

namespace WpfApp_.Views.Profile
{
    /// <summary>
    /// Логика взаимодействия для Edit_Need_data.xaml
    /// </summary>
    public partial class Edit_Need_data : Window
    {

        private List<DTO_Need> _allNeeds;
        private List<DTO_Need> _selectedNeeds;
        private List<DTO_Need> _needsCopy;
        private int _profileId;

        public Edit_Need_data(List<DTO_Need> current_need, int profile_id)
        {
            _needsCopy = new List<DTO_Need>();
            this._profileId = profile_id;
            foreach (var item in current_need)
            {
                var need = new DTO_Need()
                {
                    id = item.id,
                    title = item.title
                };
                _needsCopy.Add(need);
            }

            if (RestAPI.User.Role.title != "admin") RemoveSelect.IsEnabled = false;

            InitializeComponent();
            all_needs.SelectedValuePath = "id";
            all_needs.DisplayMemberPath = "title";
            selected_needs.SelectedValuePath = "id";
            selected_needs.DisplayMemberPath = "title";

            if (current_need != null)
            {
                _selectedNeeds = current_need;
            }
            _allNeeds = StaticInfoCollections.InfoCollections.needs.Except(current_need).ToList<DTO_Need>();
            all_needs.ItemsSource = _allNeeds;
            _selectedNeeds = current_need;
            selected_needs.ItemsSource = _selectedNeeds;
        }

        private void Add_need_Click(object sender, RoutedEventArgs e)
        {
            if (all_needs.SelectedItem != null)
            {
                _selectedNeeds.Add((DTO_Need)all_needs.SelectedItem);
                selected_needs.ItemsSource = _selectedNeeds;
                selected_needs.Items.Refresh();
                if (_selectedNeeds == null) return;
                _allNeeds.Remove((DTO_Need)all_needs.SelectedItem);
                all_needs.ItemsSource = _allNeeds;
                all_needs.Items.Refresh();
            }
        }

        private void Remove_need_Click(object sender, RoutedEventArgs e)
        {
            if (selected_needs.SelectedItem != null)
            {
                _allNeeds.Add((DTO_Need)selected_needs.SelectedItem);
                all_needs.ItemsSource = _allNeeds;
                all_needs.Items.Refresh();
                _selectedNeeds.Remove((DTO_Need)selected_needs.SelectedItem);
                selected_needs.ItemsSource = _selectedNeeds;
                selected_needs.Items.Refresh();
            }
        }

        private async void Save_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                var update = new Update()
                {
                    to_add = new List<int>(),
                    to_delete = new List<int>()
                };
                foreach (DTO_Need a in _selectedNeeds)
                {
                    if (_needsCopy.Where(x => x.id == a.id).Count() == 0) update.to_add.Add(a.id);
                }

                foreach (DTO_Need a in _needsCopy)
                {
                    if (_allNeeds.Where(x => x.id == a.id).Count() > 0) update.to_delete.Add(a.id);
                }
                
                DialogResult dialogResult = System.Windows.Forms.MessageBox.Show("Сохранение", "Сохранить изменения?", MessageBoxButtons.YesNo);
                if (dialogResult == System.Windows.Forms.DialogResult.Yes)
                {
                    update.id = _profileId;
                    
                    IRestResponse<string> response = await RestAPI.PostRestAsync<string>("/Profile/UpdateNeed", update);
                    
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
